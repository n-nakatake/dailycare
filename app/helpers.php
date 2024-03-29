<?php declare(strict_types=1);
use Carbon\Carbon;
use App\Models\Meal;

if (! function_exists('toWareki')) {
    /**
     * 西暦→和暦変換
     *
     * @param string $format 'K':元号
     *                       'k':元号略称
     *                       'Q':元号(英語表記)
     *                       'q':元号略称(英語表記)
     *                       'X':和暦年(前ゼロ表記)
     *                       'x':和暦年
     * @param string $time 変換対象となる日付(西暦)‎
     *
     * @return string $result 変換後の日付(和暦)‎
     */
    function toWareki($format, $time='now')
    {
        // 元号一覧
        $era_list = [
            // 令和(2019年5月1日〜)
            [
                'jp' => '令和', 'jp_abbr' => '令',
                'en' => 'Reiwa', 'en_abbr' => 'R',
                'time' => '20190501'
            ],
            // 平成(1989年1月8日〜)
            [
                'jp' => '平成', 'jp_abbr' => '平',
                'en' => 'Heisei', 'en_abbr' => 'H',
                'time' => '19890108'
            ],
            // 昭和(1926年12月25日〜)
            [
                'jp' => '昭和', 'jp_abbr' => '昭',
                'en' => 'Showa', 'en_abbr' => 'S',
                'time' => '19261225'
            ],
            // 大正(1912年7月30日〜)
            [
                'jp' => '大正', 'jp_abbr' => '大',
                'en' => 'Taisho', 'en_abbr' => 'T',
                'time' => '19120730'
            ],
            // 明治(1873年1月1日〜)
            // ※明治5年以前は旧暦を使用していたため、明治6年以降から対応
            [
                'jp' => '明治', 'jp_abbr' => '明',
                'en' => 'Meiji', 'en_abbr' => 'M',
                'time' => '18730101'
            ],
        ];
    
        $dt = new DateTime($time);
    
        $format_K = '';
        $format_k = '';
        $format_Q = '';
        $format_q = '';
        $format_X = $dt->format('Y');
        $format_x = $dt->format('y');
    
        foreach ($era_list as $era) {
            $dt_era = new DateTime($era['time']);
            if ($dt->format('Ymd') >= $dt_era->format('Ymd')) {
                $format_K = $era['jp'];
                $format_k = $era['jp_abbr'];
                $format_Q = $era['en'];
                $format_q = $era['en_abbr'];
                $format_X = sprintf('%02d', $format_x = $dt->format('Y') - $dt_era->format('Y') + 1);
                break;
            }
        }
    
        $result = '';
    
        foreach (str_split($format) as $val) {
            // フォーマットが指定されていれば置換する
            if (isset(${"format_{$val}"})) {
                $result .= ${"format_{$val}"};
            } else {
                $result .= $dt->format($val);
            }
        }
    
        return $result;
    }
}

if (! function_exists('getBathMethodName')) {
    /**
     * @param string $bathMethodId 入浴方法番号
     *
     * @return string $result 入浴方法名
     */
    function getBathMethodName($bathMethodId)
    {
        $bathMethodList = [
            '1' => '一般浴',
            '2' => 'シャワー浴',
            '3' => 'ストレッチャー浴',
            '4' => '機械浴',
            '5' => '清拭',
            '6' => '陰洗',
            '7' => 'その他',
        ];
        
        if (!array_key_exists($bathMethodId, $bathMethodList)) {
            return '';
        }

        return $bathMethodList[$bathMethodId];
    }
}

if (! function_exists('getAttendanceMemberName')) {
    /**
     * @param Attendance $attendance 出勤者
     *
     * @return string $result 出勤者名
     */
    function getAttendanceMemberName($attendance)
    {
        if ($attendance->user_id > 0) {
            return $attendance->user->last_name . $attendance->user->first_name;
        }

        return $attendance->part_time_member;
    }
}

if (! function_exists('getAge')) {
    /**
     * @param string $birthday 誕生日
     *
     * @return int $result 年齢
     */
    function getAge(string $birthday)
    {
        return Carbon::parse($birthday)->age;
    }
}

if (! function_exists('getTime')) {
    /**
     * @param string $date 日時（yyyy-mm-dd HH:ii）
     *
     * @return string 時間（H:ii）
     */
    function getTime(string $date)
    {
        return Carbon::parse($date)->format('G:i');
    }
}

if (! function_exists('getDateOnly')) {
    /**
     * @param string $date 日にち（yyyy-mm-dd HH:ii:ss）
     *
     * @return string m月d日
     */
    function getDateOnly(?string $date)
    {
        if (is_null($date)) {
            return '';
        }
        return Carbon::parse($date)->format('Y-m-d');
    }
}

if (! function_exists('formatDateWithYear')) {
    /**
     * @param string $date 日にち（yyyy-mm-dd || yyyy-mm-dd HH:ii）
     *
     * @return string m月d日
     */
    function formatDateWithYear(string $date)
    {
        return Carbon::parse($date)->format('Y年n月j日');
    }
}
if (! function_exists('formatDate')) {
    /**
     * @param string $date 日にち（yyyy-mm-dd || yyyy-mm-dd HH:ii）
     *
     * @return string m月d日
     */
    function formatDate(string $date)
    {
        return Carbon::parse($date)->format('n月j日');
    }
}

if (! function_exists('formatDatetime')) {
    /**
     * @param string $date 日時（yyyy-mm-dd HH:ii）
     *
     * @return string 日時（m月d日 H:ii）
     */
    function formatDatetime(string $date)
    {
        return Carbon::parse($date)->format('n月j日 G:i');
    }
}

if (! function_exists('isPast')) {
    /**
     * @param string $date 日時（yyyy-mm-dd HH:ii）
     *
     * @return string 日時（m月d日 H:ii）
     */
    function isPast(string $date)
    {
        return Carbon::parse($date)->isPast();
    }
}

if (! function_exists('getExcretionType')){

    function getExcretionType($flash, $dump)
    {
        if( $flash AND $dump ){
            return "排尿、排便 ";
        }else if( $flash ){
            return "排尿";
        }else{
            return "排便";
        }
    }

}