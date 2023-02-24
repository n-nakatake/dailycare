<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
    /**
     * 渡された年月のすべての日付を配列に入れて返す（ただし未来の場合には空配列を返す）
     */
    protected function getAllDates($dateYm, $lastDay)
    {
        $firstDay = new Carbon($dateYm . '-01');
        if($firstDay->isFuture()) {
            return []; // 未来の年月の場合、データを表示しないので空配列を返す
        } elseif ($dateYm === date('Y-m')) {
            $lastDay = (int)date('j');
        }

        $datesOfMonth = [];
        for($day = $lastDay; $day > 0; $day--) {
            $dayString = $day < 10 ? '0' . $day : $day;
            $datesOfMonth[] = $dateYm . '-' . $dayString;
        }

        return $datesOfMonth;
    }
}
