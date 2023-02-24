<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function add()
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.attendance.add')) {
            session(['fromUrl' => url()->previous()]);
        }

        $users = User::where('office_id', Auth::user()->office_id)->orderBy('id')->get();

        return view('admin.attendance.create', ['users' => $users]);
    }

    public function create(AttendanceRequest $request)
    {
        $attendanceMembers = $this->formatAttendaceMembers($request);
        Attendance::insert($attendanceMembers);

        return redirect(session()->pull('fromUrl', route('admin.top.index', ['date' => $request->attendance_date])))
            ->with('message', formatDate($request->attendance_date) . 'の出勤者を登録しました。');
    }

    public function edit(string $attendanceDate)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.attendance.edit', ['attendanceDate' => $attendanceDate])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        $users = User::where('office_id', $officeId)->orderBy('id')->get();
        $attendances = Attendance::where('attendance_date', $attendanceDate)
            ->where('office_id', $officeId)
            ->orderBy('id')
            ->get();
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
        $attendanceDate = $request->attendance_date;
        $attendancesAfter = $this->formatAttendaceMembers($request);

        try {
            DB::beginTransaction();
            Attendance::where('office_id', Auth::user()->office_id)->where('attendance_date', $attendanceDate)->delete();
            Attendance::insert($attendancesAfter);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect(route('admin.attendance.edit', ['attendanceDate' => $attendanceDate]));
        }
        
        return redirect(session()->pull('fromUrl', route('admin.top.index', ['date' => $attendanceDate])))
            ->with('message', formatDate($attendanceDate) . 'の出勤者を更新しました。');
    }
    
    /**
     * DBに保存するために出勤者データを整形
     */
    private function formatAttendaceMembers(Request $request)
    {
        $attendanceMembers = [];
        $form = $request->all();
        $now = Carbon::now();
        $officeId = Auth::user()->office_id;

        if (isset($form['day_shift_user_id']) && !empty($form['day_shift_user_id'])) {
            foreach ($form['day_shift_user_id'] as $userId) {
                $attendanceMembers[] = [
                    'office_id' => $officeId,
                    'attendance_date' => $form['attendance_date'],
                    'user_id' => $userId,
                    'part_time_member' => null,
                    'attendance_type' => Attendance::ATTENDANCE_TYPE_DAY_SHIFT,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (isset($form['part_time_member']) && !empty($form['part_time_member'])) {
            foreach ($form['part_time_member'] as $partTimeMember) {
                if (!empty($partTimeMember)) {
                    $attendanceMembers[] = [
                        'office_id' => $officeId,
                        'attendance_date' => $form['attendance_date'],
                        'user_id' => null,
                        'part_time_member' => $partTimeMember,
                        'attendance_type' => Attendance::ATTENDANCE_TYPE_DAY_SHIFT,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }
    
        if (isset($form['night_shift_user_id']) && !empty($form['night_shift_user_id'])) {
            foreach ($form['night_shift_user_id'] as $userId) {
                $attendanceMembers[] = [
                    'office_id' => $officeId,
                    'attendance_date' => $form['attendance_date'],
                    'user_id' => $userId,
                    'part_time_member' => null,
                    'attendance_type' => Attendance::ATTENDANCE_TYPE_NIGHT_SHIFT,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        return $attendanceMembers;
    }
}
