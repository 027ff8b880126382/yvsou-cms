<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/MailSetting.php
class MailSetting extends Model
{
    protected $fillable = ['key', 'value'];
    public $timestamps = true;

    public static function getSettings()
    {
        return self::pluck('value', 'key')->toArray();
    }

    public static function updateSettings(array $data)
    {
        foreach ($data as $key => $value) {
            self::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
