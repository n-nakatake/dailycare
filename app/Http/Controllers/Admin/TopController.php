<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\CareCertification;
use App\Models\Meal;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TopController extends Controller
{
    public function index(Request $request)
    {
        $targetDate = $request->date ? $request->date : date('Y-m-d');

        // 出勤者データ
        $officeId = Auth::user()->office_id;
        $attendances = Attendance::where('attendance_date', $targetDate)
            ->where('office_id', $officeId)
            ->get();
        $dayShiftMembers = $attendances->where('attendance_type', Attendance::ATTENDANCE_TYPE_DAY_SHIFT)->sortBy('id');
        $nightShiftMembers = $attendances->where('attendance_type', Attendance::ATTENDANCE_TYPE_NIGHT_SHIFT)->sortBy('id');

        // 利用者データ
        $residents = Resident::exist()
            ->with([
                'vitals' => function ($query) use ($targetDate) {
                    $query->where('vital_time', '>', $targetDate . ' 00:00:00')
                        ->where('vital_time', '<=', $targetDate . ' 23:59:59')
                        ->orderByDesc('vital_time');
                },
                'meals' => function ($query) use ($targetDate) {
                    $query->where('meal_time', '>', $targetDate . ' 00:00:00')
                        ->where('meal_time', '<=', $targetDate . ' 23:59:59')
                        ->orderByDesc('meal_time');
                },
                'baths' => function ($query) use ($targetDate) {
                    $query->where('bath_time', '>', $targetDate . ' 00:00:00')
                        ->where('bath_time', '<=', $targetDate . ' 23:59:59');
                },
                'excretions' => function ($query) use ($targetDate) {
                    $query->where('excretion_time', '>', $targetDate . ' 00:00:00')
                        ->where('excretion_time', '<=', $targetDate . ' 23:59:59');
                },
            ])
            ->get();

        return view('admin.top.index', [
            'dayShiftMembers' => $dayShiftMembers,
            'nightShiftMembers' => $nightShiftMembers,
            'residents' => $residents,
            'mealBldOptions' => Meal::MEAL_BLD_OPTIONS,
            'mealIntakeOptions' => Meal::MEAL_INTAKE_OPTIONS,
            'careLevels' => CareCertification::LEVELS,
        ]);
    }
}