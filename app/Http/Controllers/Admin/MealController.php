<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MealHistory;
use App\Http\Requests\MealRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Meal;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    public function add(int $residentId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.meal.add', ['residentId' => $residentId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        $users = User::where('office_id', $officeId)->orderBy('id')->get();
        $residents = Resident::where('office_id', $officeId)
            ->orderBy('last_name_k')
            ->orderBy('first_name_k')
            ->get();
        return view('admin.meal.create', [
            'users' => $users,
            'residents' => $residents,
            'residentId' => $residentId,
            'mealBldOptions' => Meal::MEAL_BLD_OPTIONS,
            'mealIntakeOptions' => Meal::MEAL_INTAKE_OPTIONS,
        ]);
    }
    
    public function create(MealRequest $request)
    {
        $meal = new Meal;
        $form = $request->all();
        $form['meal_time'] = $form['meal_date'] . ' ' . $form['meal_time'];
        $form['office_id'] = Auth::user()->office_id;

        // フォームから送信されてきた_tokenを削除する
        unset($form['meal_date']);
        unset($form['_token']);

        // データベースに保存する
        $meal->fill($form);
        $meal->save();
        $message = formatDate($form['meal_time']) . 'の' . Meal::MEAL_BLD_OPTIONS[$form['meal_bld']] . 'の食事摂取量を登録しました。';
        $mealYm = substr($form['meal_time'], 0, 7);

        return redirect(session()->pull('fromUrl', route('admin.meal.index', ['residentId' => $request->resident_id, 'meal_ym' => $mealYm])))
            ->with('message', $message);
    }

    public function edit(Request $request, int $residentId, int $mealId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.meal.edit', ['residentId' => $residentId, 'mealId' => $mealId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        $users = User::where('office_id', $officeId)->orderBy('id')->get();
        $meal = Meal::where('office_id', $officeId)->where('id', $mealId)->first();

        if (empty($meal)) {
            abort(404);    
        }

        return view('admin.meal.edit', [
            'mealForm' => $meal,
            'users' => $users,
            'mealBldOptions' => Meal::MEAL_BLD_OPTIONS,
            'mealIntakeOptions' => Meal::MEAL_INTAKE_OPTIONS,
        ]);
    }

    public function update(MealRequest $request, int $residentId, int $mealId)
    {
        $meal = Meal::find($mealId);
        $form = $request->all();
        $form['meal_time'] = $form['meal_date'] . ' ' . $form['meal_time'];
        unset($form['_token']);
        
        // 該当するデータを上書きして保存する
        $meal->fill($form)->save();
        $message = formatDate($form['meal_time']) . 'の' . Meal::MEAL_BLD_OPTIONS[$form['meal_bld']] . 'の食事摂取量を更新しました。';
        $mealYm = substr($form['meal_time'], 0, 7);

        return redirect(session()->pull('fromUrl', route('admin.meal.index', ['residentId' => $residentId, 'meal_ym' => $mealYm])))
            ->with('message', $message);
    }    
    
    public function index(Request $request, int $residentId)
    {
        $officeId = Auth::user()->office_id;
        $residents = Resident::where('office_id', $officeId)
            ->orderBy('last_name_k')
            ->orderBy('first_name_k')
            ->get();

        $requestDate = $request->meal_ym;
        $dateYm = checkdate((int) substr($requestDate, 5, 2), 1, (int) substr($requestDate, 0, 4)) ? $request->meal_ym : date('Y-m');
        $meals = [];

        $year = substr($dateYm, 0, 4);
        $month = substr($dateYm, 5, 2);
        $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
        $meals = Meal::where('office_id', $officeId)
            ->where('resident_id', $residentId)
            ->whereBetween('meal_time', [
                $year . '-' . $month . '-01 00:00:00',
                $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
            ])
            ->orderBy('meal_time', 'desc')
            ->get();

        return view('admin.meal.index', [
            'meals' => $this->formatMeals($meals),
            'dateYm' => $dateYm,
            'residents' => $residents,
            'residentId' => $residentId,
            'mealBldOptions' => Meal::MEAL_BLD_OPTIONS,
            'mealIntakeOptions' => Meal::MEAL_INTAKE_OPTIONS,
            'datesOfMonth' => $this->getAllDates($dateYm, $lastDay),
        ]);
    }    

    public function delete(Request $request, int $residentId, int $mealId)
    {
        $meal = meal::find($mealId);
        $mealYm = substr($meal->meal_time, 0, 7);
        $message = formatDate($meal->meal_time) . 'の' . Meal::MEAL_BLD_OPTIONS[$meal->meal_bld] . 'の食事摂取量を削除しました。';
        $meal->delete();

        return redirect(session()->pull('fromUrl', route('admin.meal.index', ['residentId' => $residentId, 'meal_ym' => $mealYm])))
            ->with('message', $message);
    }
    
    private function formatMeals(Collection $meals)
    {
        $mealsByDay = [];
        if ($meals->isNotEmpty()){
            $mealBlds = Meal::MEAL_BLD_OPTIONS;
            foreach($meals as $meal) {
                $date = substr($meal->meal_time, 0, 10);
                $mealsByDay[$date][$mealBlds[$meal->meal_bld]] = $meal;
            }
        }

        return $mealsByDay;
    }
}
