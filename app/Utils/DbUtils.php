<?php


namespace App\Utils;


use Illuminate\Support\Facades\DB;

class DbUtils
{

    public static function getMaxId(string $table, $colName, $colVal): int
    {
        return DB::table($table)->select()->where($colName, "=", $colVal)->max("id") ?? 0;
    }

}
