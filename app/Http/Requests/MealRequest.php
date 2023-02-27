<?php

namespace App\Http\Requests;

use App\Models\Meal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'resident_id' => 'required|exists:residents,id',
            'user_id' => 'required|exists:users,id',
            'meal_date' => 'required|date_format:Y-m-d',
            'meal_time' => 'required|date_format:H:i',
            'meal_bld' => 'required|in:1,2,3',
            'meal_intake_rice' => 'required|in:0,1,2,3,4,5,6,7,8,9,10',
            'meal_intake_side' => 'required|in:0,1,2,3,4,5,6,7,8,9,10',
            'meal_intake_soup' => 'required|in:0,1,2,3,4,5,6,7,8,9,10',
            'meal_note' => 'nullable|max:2000',
        ];
    }
    
    /**
     * バリデータインスタンスの設定
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $officeId = Auth::user()->office_id;
        if (!is_null($this->input('meal_date')) && !is_null($this->input('meal_bld'))) {
            // 登録時に同じ日付で同じ食事のデータが既にある場合エラーにする
            $isCreate = strpos($this->path(), 'create') !== false ? true : false;
            $sameMeal = Meal::where('resident_id', $this->input('resident_id'))
                ->where('office_id', $officeId)
                ->where('meal_time', '>', $this->input('meal_date') . ' 00:00:00')
                ->where('meal_time', '<=', $this->input('meal_date') . ' 23:59:59')
                ->where('meal_bld', $this->input('meal_bld'))
                ->get();
            $validator->after(function ($validator) use ($isCreate, $sameMeal) {
                if ($isCreate && $sameMeal->count() > 0) {
                    $routing = route('admin.meal.edit', ['residentId' => $this->input('resident_id'), 'mealId' => $sameMeal->first()->id]);
                    $validator->errors()->add('meal_date', '指定された日付の食事は<a href="' . $routing . '">既に登録済み</a>です');
                    $validator->errors()->add('meal_bld', '指定された日付の食事は<a href="' . $routing . '">既に登録済み</a>です');
                }
            });
            
            // 編集時に異なる日付または食事に変更しており、変更後と同じ日付・同じ食事のデータが既にある場合エラーにする
            if (!$isCreate) {
                $originalMeal = Meal::where('office_id', $officeId)
                    ->where('resident_id', $this->route('residentId'))
                    ->where('id', $this->route('mealId'))
                    ->first();
                if (is_null($originalMeal)) {
                    abort(404);
                }
                $isEditDate = $this->input('meal_date') !== substr($originalMeal->meal_time, 0, 10) ? true : false;
                $isEditMealBld = (int)$this->input('meal_bld') !== $originalMeal->meal_bld ? true : false;
                if ($isEditDate || $isEditMealBld) {
                    $sameMeal = Meal::where('office_id', $officeId)
                        ->where('resident_id', $this->input('resident_id'))
                        ->where('meal_time', '>', $this->input('meal_date') . ' 00:00:00')
                        ->where('meal_time', '<=', $this->input('meal_date') . ' 23:59:59')
                        ->where('meal_bld', $this->input('meal_bld'))
                        ->get();
                    $validator->after(function ($validator) use ($sameMeal) {
                        if ($sameMeal->count() > 0) {
                            $routing = route('admin.meal.edit', ['residentId' => $this->input('resident_id'), 'mealId' => $sameMeal->first()->id]);
                            $validator->errors()->add('meal_date', '指定された日付の食事は<a href="' . $routing . '">既に登録済み</a>です');
                            $validator->errors()->add('meal_bld', '指定された日付の食事は<a href="' . $routing . '">既に登録済み</a>です');
                        }
                    });
                }
            }
        }
    }
}
