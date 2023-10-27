<?php // Code within app\Helpers\returnhelpers.php

namespace App\Helpers;


class ReturnHelpers
{
    public static function jsonApiReturn($ret, $inApiFormat = true) {
        if($inApiFormat) {
            if(empty($ret) or ($ret == NULL) or !$ret) {
                return response()->json([
                    'result' => [],
                    'status' => false
                ]);
            } else {
                return response()->json([
                    'result' => $ret,
                    'status' => true
                ]);
            }
        }
        return $ret;
    }

    public static function jsonApiReturnSecond($ret, $case, $inApiFormat = true) {
        if($inApiFormat) {
            if(empty($ret) or ($ret == NULL) or !$ret) {
                return response()->json([
                    'result' => [],
                    'status' => false
                ]);
            } else {
                return response()->json([
                    'result' => $ret,
                    'case' => $case,
                    'status' => true
                ]);
            }
        }
        return $ret;
    }
}
