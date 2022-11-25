<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MealHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Meal;
use Carbon\Carbon;

class MealController extends Controller
{
    //
    public function add(int $residentId))
    {
        $users = User::all();
        return view('admin.meal.create', ['users' => $users, 'residentId' => $residentId]);
    }
    
    public function create(Request $request, int $residentId)
    {
        // Validationを行う
        $this->validate($request, Meal::$rules);
        $meal = new Meal;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $meal->fill($form);
        $meal->save();

        return redirect('admin/meal/create');
    }

    public function edit(Request $request, $residentId)
    {
        // Meal Modelからデータを取得する
        $meal = Meal::find($request->id);
        if (empty($meal)) {
            abort(404);    
        }
        return view('admin.meal.edit', ['meal_form' => $meal]);
    }

    public function update(Request $request, $residentId)
    {
        // Validationをかける
        $this->validate($request, Meal::$rules);
        // Profile Modelからデータを取得する
        $meal = Meal::find($request->id);
        // 送信されてきたフォームデータを格納する
        $meal_form = $request->all();

        unset($meal_form['remove']);
        unset($meal_form['_token']);
        
        // 該当するデータを上書きして保存する
        $meal->fill($meal_form)->save();

        // プロフィール履歴テーブルにデータを保存
        $mealhistory = new MealHistory();
        $mealhistory->meal_id = $meal->id;
        $mealhistory->edited_at = Carbon::now();
        $mealhistory->save();

        return redirect('admin/meal/edit?id='. $request->id);

    }    
    
    public function index(Request $request, $residentId)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $meals = Meal::where('name', $cond_name)->get();
        } else {
            $meals = Meal::all();
        }
        return view('admin.meal.index', ['meals' => $meals, 'cond_name' => $cond_name]);
    }    

    public function delete(Request $request, $residentId)
    {
        // 該当するMeal Modelを取得
        $meal = meal::find($request->id);
        // 削除する
        $meal->delete();
        return redirect('admin/meal/');
      }     
    
    
}
