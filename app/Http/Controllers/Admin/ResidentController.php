<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResidentRequest;
use App\Http\Requests\LeaveResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Models\Resident;
use App\Models\CareCertification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    public function add()
    {
        return view('admin.resident.create', ['careLevels' => CareCertification::LEVELS]);
    }

    public function create(CreateResidentRequest $request)
    {
        $resident = new Resident;
        $careCertification = new CareCertification;
        $form = $request->all();
        $form['office_id'] = Auth::user()->office_id;
        $form['key_person_address'] = encrypt($form['key_person_address']);
        $form['key_person_tel1'] = encrypt($form['key_person_tel1']);
        $form['key_person_tel2'] = encrypt($form['key_person_tel2']);
        $form['key_person_mail'] = encrypt($form['key_person_mail']);
        $careCertification->level = $form['level'];
        $careCertification->start_date = $form['level_start_date'] . ' 00:00:00';
        $careCertification->end_date = $form['level_end_date'] . ' 23:59:59';
        $resident->image_path = null;

        // formに画像があれば、保存する
        if ($request->file('image')) {
            $officeId = Auth::user()->office_id;
            $imagePath = $request->file('image')->store("protected/$officeId/residents");
            $resident->image_path = $imagePath;
        }
        
        // 不要な値を削除する
        unset(
            $form['_token'],
            $form['image'],
            $form['level'],
            $form['level_start_date'],
            $form['level_end_date']
        );

        // データベースに保存する
        DB::transaction(function () use($form, $resident, $careCertification) {
            $resident->fill($form)->save();
            if ($careCertification->level > 0) {
                $careCertification->resident_id = $resident->id;
                $careCertification->save();
            }
        });

        $message = $form['last_name'] . $form['first_name'] . 'さんの利用者情報を登録しました。';

        return redirect(route('admin.resident.index'))
            ->with('message', $message);
    }


    public function index(Request $request)
    {
        $residents = Resident::where('office_id', Auth::user()->office_id)
            ->orderBy('last_name_k')
            ->orderBy('first_name_K')
            ->get();

        return view('admin.resident.index', ['residents' => $residents, 'careLevels' => CareCertification::LEVELS]);
    }

    public function edit(Request $request, $residentId)
    {
        // Resident Modelからデータを取得する
        $resident = Resident::where('office_id', Auth::user()->office_id)->where('id', $residentId)->first();
        if (empty($resident)) {
            abort(404);
        }
        $careCertifications = $resident->careCertifications()->orderBy('start_date', 'desc')->get();

        return view('admin.resident.edit', [
            'residentForm' => $resident,
            'careLevels' => CareCertification::LEVELS,
            'careCertifications' => $careCertifications,
        ]);
    }

    public function update(UpdateResidentRequest $request, $residentId)
    {
        // Resident Modelからデータを取得する
        $resident = Resident::where('office_id', Auth::user()->office_id)->where('id', $residentId)->first();
        $careCertification = CareCertification::find($request->care_certification_id);
        if (is_null($resident)) {
            abort(404);
        }

        // 送信されてきたフォームデータを格納する
        $form = $request->all();
        $form['key_person_address'] = encrypt($form['key_person_address']);
        $form['key_person_tel1'] = encrypt($form['key_person_tel1']);
        $form['key_person_tel2'] = encrypt($form['key_person_tel2']);
        $form['key_person_mail'] = encrypt($form['key_person_mail']);

        $deleteImagePath = '';
        if ($request->remove) {
            $deleteImagePath = $resident->image_path;
            $resident->image_path = null;
        }
        if ($request->file('image')) {
            $deleteImagePath = $resident->image_path;
            $officeId = Auth::user()->office_id;
            $imagePath = $request->file('image')->store("protected/$officeId/residents");
            $resident->image_path = $imagePath;
        }

        if (is_null($careCertification) && $form['level'] > 0) {
            $careCertification = new CareCertification; // 要介護認定データを作成するパターン
            $careCertification->resident_id = $residentId;
        } 
        if ($careCertification) {
            $careCertification->level = $form['level'];
            $careCertification->start_date = $form['level_start_date'] . ' 00:00:00';
            $careCertification->end_date = $form['level_end_date'] . ' 23:59:59';
        }
        $newCareCertification = null;
        if ($form['new_level'] > 0) {
            $newCareCertification = new CareCertification;
            $newCareCertification->resident_id = $residentId;
            $newCareCertification->level = $form['new_level'];
            $newCareCertification->start_date = $form['new_level_start_date'] . ' 00:00:00';
            $newCareCertification->end_date = $form['new_level_end_date'] . ' 23:59:59';
        }
        
        unset(
            $form['_token'],
            $form['image'],
            $form['level'],
            $form['level_start_date'],
            $form['level_end_date'],
            $form['new_level'],
            $form['new_level_start_date'],
            $form['new_level_end_date']
        );

        DB::transaction(function () use($form, $resident, $careCertification, $newCareCertification) {
            $resident->fill($form)->save();
            if ($careCertification) {
                $careCertification->resident_id = $resident->id;
                $careCertification->save();
            }
            if ($newCareCertification) {
                $newCareCertification->save();
            }
        });
        if (!empty($deleteImagePath)) {
            Storage::delete($deleteImagePath); //画像ファイルの削除
        }

        $message = $form['last_name'] . $form['first_name'] . 'さんの利用者情報を更新しました。';

        return redirect(session()->pull('fromUrl', route('admin.resident.index')))
            ->with('message', $message);
    }
    
   public function leaving(int $residentId)
   {
        // 該当するResident Modelを取得
        $resident = Resident::where('office_id', Auth::user()->office_id)->where('id', $residentId)->first();
        if (is_null($resident)) {
            abort(404);
        }

        return view('admin.resident.leave', ['resident' => $resident]);
    }
    
   public function leave(LeaveResidentRequest $request, int $residentId)
   {
        $resident = Resident::where('office_id', Auth::user()->office_id)->where('id', $residentId)->first();
        if (is_null($resident)) {
            abort(404);
        }

        // 退所情報を登録する
        $resident->left_date = $request->left_date . ' 23:59:59';
        $resident->leaving_note = $request->leaving_note;
        $resident->save();

        $message = ($resident->last_name) . ($resident->first_name) . 'さんは退所しました。';

        return redirect(route('admin.resident.index'))->with('message', $message);
    }
    
   public function delete(Request $request, int $residentId)
   {
        // 該当するResident Modelを取得
        $resident = resident::find($residentId);
        if (is_null($resident)) {
            abort(404);
        }

        if ($resident->image_path) {
            Storage::delete($resident->image_path); //画像ファイルの削除
        }
        $resident->delete();

        $message = ($resident->last_name) . ($resident->first_name) . 'さんの入居者情報を削除しました。';

        return redirect(route('admin.resident.index'))->with('message', $message);
    }
}