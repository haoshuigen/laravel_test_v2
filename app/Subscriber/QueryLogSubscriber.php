<?php

namespace App\Subscriber;

use App\Service\SqlLogService;
use Illuminate\Support\Facades\DB;

/**
 * @desc Listen all sql execution and record it
 */
class QueryLogSubscriber
{
    public function __construct()
    {
        DB::listen(function ($query) {
            $sql = $query->sql;
            $bindings = $query->bindings;
            $usedTime = $query->time;

            foreach ($bindings as $replace) {
                $sql = preg_replace('/\?/', "'" . $replace . "'", $sql, 1);
            }

            SqlLogService::record(null, $sql, $usedTime);
        });
    }
}
