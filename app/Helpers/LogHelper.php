<?php

namespace App\Helpers;
use Exception;

class LogHelper
{

    static function format_to_array(Exception $e): array {
        return [
            "message" => $e->getMessage() ?? null,
            "code" => $e->getCode() ?? null,
            "file" => $e->getFile() ?? null,
            "line" => $e->getLine() ?? null,
            "trace" => $e->getTraceAsString() ?? null
        ];
    }

}
