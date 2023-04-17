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

class ResidentController extends Controller
{
    public function add()
    {
        return view('admin.resident.create', ['careLevels' => CareCertification::LEVELS]);
    }

    public function create(CreateResidentRequest $request)
    {
        $resident = new Resident;
        $careLevel = new CareCertification;
        $form = $request->all();
        $form['office_id'] = Auth::user()->office_id;
        $form['key_person_address'] = encrypt($form['key_person_address']);
        $form['key_person_tel1'] = encrypt($form['key_person_tel1']);
        $form['key_person_tel2'] = encrypt($form['key_person_tel2']);
        $form['key_person_mail'] = encrypt($form['key_person_mail']);
        $careLevel->level = $form['level'];
        $careLevel->start_date = $form['level_start_date'];
        $careLevel->end_date = $form['level_end_date'];
        
         // formに画像があれば、保存する
        if (isset($form['image'])) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $resident->image_path = Storage::disk('s3')->url($path);
        } else {
            $resident->image_path = null;
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
        DB::transaction(function () use($form, $resident, $careLevel) {
            $resident->fill($form)->save();
            $careLevel->resident_id = $resident->id;
            $careLevel->save();
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
        $careCertifications = $resident->careCertifications()->orderBy('start_date')->get();

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
        if (is_null($resident) || is_null($careCertification)) {
            abort(404);
        }

        // 送信されてきたフォームデータを格納する
        $form = $request->all();
        $form['key_person_address'] = encrypt($form['key_person_address']);
        $form['key_person_tel1'] = encrypt($form['key_person_tel1']);
        $form['key_person_tel2'] = encrypt($form['key_person_tel2']);
        $form['key_person_mail'] = encrypt($form['key_person_mail']);

        if ($request->remove == 'true') {
           $resident['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $resident->image_path = Storage::disk('s3')->url($path);
        } else {
            $resident['image_path'] = $resident->image_path;
        }

        $careCertification->level = $form['level'];
        $careCertification->start_date = $form['level_start_date'];
        $careCertification->end_date = $form['level_end_date'];
        $newCareCertification = null;
        if (isset($form['new_level'])) {
            $newCareCertification = new CareCertification;
            $newCareCertification->resident_id = $residentId;
            $newCareCertification->level = $form['new_level'];
            $newCareCertification->start_date = $form['new_level_start_date'];
            $newCareCertification->end_date = $form['new_level_end_date'];
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
            $careCertification->resident_id = $resident->id;
            $careCertification->save();
            if ($newCareCertification) {
            // dd($newCareCertification);
                $newCareCertification->save();
            }
        });
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
        $resident->left_date = $request->left_date;
        $resident->leaving_note = $request->leaving_note;
        $resident->save();

        $message = ($resident->last_name) . ($resident->first_name) . 'さんは退所しました。';

        return redirect(session()->pull('fromUrl', route('admin.resident.index')))
            ->with('message', $message);
    }
    
   public function delete(Request $request)
   {
        // 該当するResident Modelを取得
        $resident = resident::find($request->id);

        $message = ($resident->last_name) . ($resident->first_name) . 'さんの入居者情報を削除しました。';
        // 削除する
        $resident->delete();

        return redirect(session()->pull('fromUrl', route('admin.resident.index')))
            ->with('message', $message);
    }
}