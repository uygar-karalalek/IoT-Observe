<?php


namespace App\Utils;


use Illuminate\Support\Facades\DB;

class DbUtils
{

    public static function getMaxId(string $table): int
    {
        return DB::table($table)->select()->max("id") ?? 0;
    }

}
