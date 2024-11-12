<?php

namespace App\Service;

use App\Models\SqlExecutionLog;
use Exception;
use Illuminate\Database\QueryException;

/**
 * record all sql execution into db
 * Class SqlLogService
 * @package app\service
 */
class SqlLogService
{
    /**
     * @desc record sql execution log into db
     * @param Exception|null $e
     * @param string $sql
     * @param float $usedTime
     * @return void
     */
    public static function record(Exception|null $e, string $sql, float $usedTime = 0): void
    {
        if (!$e instanceof QueryException && empty($sql)) {
            return;
        }

        $sql = !is_null($e) && method_exists($e, 'getSql') ? $e->getSql() : $sql;
        $sqlLogModel = new SqlExecutionLog();

        if ($sql && stripos($sql, $sqlLogModel->getTable()) === false) {
            $connectionType = config('database.default');
            $databaseUser = config('database.connections.' . $connectionType . '.username');

            SqlExecutionLog::create([
                'user'          => $databaseUser,
                'sql'           => $sql,
                'time'          => $usedTime,
                'error'         => !is_null($e) ? $e->getMessage() : '',
                'create_time'   => time()
            ]);
        }
    }
}
