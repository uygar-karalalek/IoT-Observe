<?php


namespace App\Types;


class Operators
{

    public static string $GREATER_THAN = ">";
    public static string $LESSER_THAN = "<";
    public static string $GREATER_THAN_OR_EQUAL = ">=";
    public static string $LESSER_THAN_OR_EQUAL = "<=";

    public static function OPERATORS() {
        return [
            self::$GREATER_THAN,
            self::$LESSER_THAN,
            self::$GREATER_THAN_OR_EQUAL,
            self::$LESSER_THAN_OR_EQUAL
        ];
    }

}
