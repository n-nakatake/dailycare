<?php declare(strict_types=1);

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