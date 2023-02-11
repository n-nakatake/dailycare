<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function add()
    {
        $users = User::all()->sortBy('id');

        return view('admin.attendance.create', ['users' => $users]);
    }

    public function create(AttendanceRequest $request)
    {
        $attendanceMembers = $this->formatAttendaceMembers($request);

        Attendance::insert($attendanceMembers);
        $formattedAttendanceDate = $this->formatAttendaceDate($request->attendance_date);

        return redirect(route('admin.top.index'))->with('message', $formattedAttendanceDate . 'の出勤者を登録しました。');
    }

    public function edit(string $attendanceDate)
    {
        $users = User::all();
        // bath Modelからデータを取得する
        $attendances = Attendance::where('attendance_date', $attendanceDate)->orderBy('id')->get();
        if ($attendances->isEmpty()) {
            abort(404);
        }
        
        // 日勤のユーザーIDだけを抽出
        $dayShiftUsers = $attendances->map(function ($attendance) {
            if (!is_null($attendance->user_id) && $attendance->attendance_type === Attendance::ATTENDANCE_TYPE_DAY_SHIFT) {
                return $attendance['user_id'];   
            }
        })->toArray();

        // 日勤の非常勤者名だけを抽出
        $partTimeMembers = $attendances
            ->whereNotNull('part_time_member')
            ->where('attendance_type', Attendance::ATTENDANCE_TYPE_DAY_SHIFT)
            ->pluck('part_time_member')
            ->toArray();

        // 夜勤のユーザーIDだけを抽出
        $nightShiftUsers = $attendances->map(function ($attendance) {
            if (!is_null($attendance->user_id) > 0 && $attendance->attendance_type === Attendance::ATTENDANCE_TYPE_NIGHT_SHIFT) {
                return $attendance['user_id'];   
            }
        })->toArray();

        return view('admin.attendance.edit', [
            'attendanceDate' => $attendanceDate,
            'dayShiftUsers' => $dayShiftUsers,
            'partTimeMembers' => $partTimeMembers,
            'nightShiftUsers' => $nightShiftUsers,
            'users' => $users,
        ]);
    }

    public function update(AttendanceRequest $request)
    {
        // Bath Modelからデータを取得する
        $attendanceDate = $request->attendance_date;
        $attendancesAfter = $this->formatAttendaceMembers($request);

        try {
            DB::beginTransaction();
            Attendance::where('attendance_date', $attendanceDate)->delete();
            Attendance::insert($attendancesAfter);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect(route('admin.attendance.edit', ['attendanceDate' => $attendanceDate]));
        }
        
        $formattedAttendanceDate = $this->formatAttendaceDate($attendanceDate);

        return redirect(route('admin.top.index'))->with('message', $formattedAttendanceDate . 'の出勤者を更新しました。');
    }
    
    /**
     * DBに保存するための出勤者データを整形
     */
    private function formatAttendaceMembers(Request $request)
    {
        $attendanceMembers = [];
        $form = $request->all();

        if (isset($form['day_shift_user_id']) && !empty($form['day_shift_user_id'])) {
            foreach ($form['day_shift_user_id'] as $userId) {
                $attendanceMembers[] = [
                    'attendance_date' => $form['attendance_date'],
                    'user_id' => $userId,
                    'part_time_member' => null,
                    'attendance_type' => Attendance::ATTENDANCE_TYPE_DAY_SHIFT,
                ];
            }
        }

        if (isset($form['part_time_member']) && !empty($form['part_time_member'])) {
            foreach ($form['part_time_member'] as $partTimeMember) {
                $attendanceMembers[] = [
                    'attendance_date' => $form['attendance_date'],
                    'user_id' => null,
                    'part_time_member' => $partTimeMember,
                    'attendance_type' => Attendance::ATTENDANCE_TYPE_DAY_SHIFT,
                ];
            }
        }
    
        if (isset($form['night_shift_user_id']) && !empty($form['night_shift_user_id'])) {
            foreach ($form['night_shift_user_id'] as $userId) {
                $attendanceMembers[] = [
                    'attendance_date' => $form['attendance_date'],
                    'user_id' => $userId,
                    'part_time_member' => null,
                    'attendance_type' => Attendance::ATTENDANCE_TYPE_NIGHT_SHIFT,
                ];
            }
        }

        return $attendanceMembers;
    }
    
    /**
     * DBに保存するための出勤者データを整形
     */
    private function formatAttendaceDate(string $attendanceDate)
    {
        return substr($attendanceDate, 0, 4) . '年'
            . substr($attendanceDate, 5, 2) . '月'
            . substr($attendanceDate, 8, 2) . '日';
    }
}
