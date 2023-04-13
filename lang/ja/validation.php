<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute は :date より後の日付を指定してください',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => ':attribute は 今日 よりも前のものを指定してください',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute must have between :min and :max items.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute must be between :min and :max.',
        'string' => 'The :attribute must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ':attribute が一致しません',
    'current_password' => 'パスワードが正しくありません',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => ':attributeは:formatで入力してください',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => ' :attribute has invalid image dimensions.',
    'distinct' => ':attributeと同じ人が選択されています',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => ':attributeが正しくありません',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => ':attributeが正しくありません',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'array' => 'The :attribute must have less than :value items.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'numeric' => 'The :attribute must be less than :value.',
        'string' => 'The :attribute must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute must not have more than :value items.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute must not have more than :max items.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'numeric' => 'The :attribute must not be greater than :max.',
        'string' => ':max文字以内で入力してください',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute must have at least :min items.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'numeric' => 'The :attribute must be at least :min.',
        'string' => ':attribute は :min 文字以上で入力してください',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => [
        'letters' => ':attributeは、少なくとも1つの文字が含まれていなければなりません。',
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => ':attributeは、少なくとも1つの数字が含まれていなければなりません。',
        'symbols' => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute  を正しく入力してください',
    'required' => ':attribute を入力してください',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => ':attribute',
    'required_without_all' => '少なくとも1人入力してください',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'array' => 'The :attribute must contain :size items.',
        'file' => 'The :attribute must be :size kilobytes.',
        'numeric' => 'The :attribute must be :size.',
        'string' => 'The :attribute must be :size characters.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute may not start with one of the following: :values.',
    'string' => ':attributeは文字列で入力してください',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'この:attribute はすでに使われています',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'title' => 'タイトル',
        'body' => '本文',
        'name' => '名前',
        'gender' => '性別',
        'hobby' => '趣味',
        'password' => 'パスワード',
        'user_code' => 'ユーザーID',
        'introduction' => '自己紹介',
        'user_id' => '記録者',
        'resident_id' => '利用者',
        'last_name' => '性',
        'first_name' => '名',
        'last_name_k' => '性（フリガナ）',
        'first_name_k' => '名（フリガナ）',
        'birthday' => '誕生日',
        'gender' => '性別',
        'level' => '介護度',
        'level_start_date' => '開始日',
        'level_end_date' => '終了日',
        'key_person_tel1' => 'キーバーソン電話番号1',
        'key_person_tel2' => 'キーバーソン電話番号2',
        'key_person_mail' => 'キーバーソンメールアドレス',
        'vital_time' => '記録時間',
        'vital_kt' => '体温、血圧↑、血圧↓のいずれかは入力してください1',
        'vital_bp_u' => '体温、血圧↑、血圧↓のいずれかは入力してください2',
        'vital_bp_d' => '体温、血圧↑、血圧↓のいずれかは入力してください3',
        'bath_date' => '入浴日時',
        'bath_time' => '入浴時間',
        'bath_method' => '入浴方法',
        'bath_note' => '特記',
        'attendance_date' => '日付',
        'part_time_member.0' => '非常勤1',
        'part_time_member.1' => '非常勤2',
        'part_time_member.2' => '非常勤3',
        'meal_bld' => '食事',
        'meal_intake_rice' => '主食',
        'meal_intake_side' => '副食',
        'meal_intake_soup' => '汁物',
        'meal_date' => '食事日時',
        'meal_time' => '食事時間',
        'meal_note' => '特記',
        'excretion_date' => '排泄日時',
        'excretion_time' => '排泄時間',
        'excretion_flash' => '排尿、排泄のどちらかにチェックをつけてください',
        'current_password' => '現在のパスワード',
        'password' => '新しいパスワード',
    ],
];
