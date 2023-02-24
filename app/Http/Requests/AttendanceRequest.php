<?php

namespace App\Http\Requests;

use App\Models\Attendance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AttendanceRequest extends FormRequest
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
            'attendance_date' => 'required|date_format:Y-m-d',
            'day_shift_user_id.*' => 'nullable|exists:users,id|distinct',
            'part_time_member.*' => 'nullable|string|max:12',
            'night_shift_user_id.*' => 'nullable|exists:users,id|distinct',
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
        // 1人も選択または入力されていない場合エラーにする
        $isExistDayShiftUsers = $this->input('day_shift_user_id') ? true : false;
        $isExistPartTimeMembers
            = array_keys($this->input('part_time_member')) !== array_keys($this->input('part_time_member'), null) ? true : false;
        $isExistNightShiftUsers = $this->input('night_shift_user_id') ? true : false;
        $validator->after(function ($validator) use ($isExistDayShiftUsers, $isExistPartTimeMembers, $isExistNightShiftUsers) {
            if (!$isExistDayShiftUsers && !$isExistPartTimeMembers && !$isExistNightShiftUsers) {
                $validator->errors()->add('all_attendance_member', '少なくとも1人選択または入力してください');
            }
        });
        
        // 登録時に同じ日付のデータが既にある場合エラーにする
        if (!is_null($this->input('attendance_date'))) {
            $isCreate = strpos($this->path(), 'create') !== false ? true : false;
            $sameDateAttendance = Attendance::where('office_id', Auth::user()->office_id)
                ->where('attendance_date', $this->input('attendance_date'))->get();
            $routing = route('admin.attendance.edit', ['attendanceDate' => $this->input('attendance_date')]);
            $validator->after(function ($validator) use ($isCreate, $sameDateAttendance, $routing) {
                if ($isCreate && $sameDateAttendance->count() > 0) {
                    $validator->errors()->add('attendance_date', '指定された日付の出勤者は<a href="' . $routing . '">既に登録済み</a>です');
                }
            });
        }
    }
}
