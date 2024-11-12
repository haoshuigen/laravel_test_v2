<?php

namespace App\Service;

use Exception;
use Generator;
use Illuminate\Support\Facades\DB;

class DataService
{
    /**
     * @desc execute user's input sql
     * @param int $offset
     * @param int $pageSize
     * @param string $sql
     * @return array
     */
    public static function getData(string $sql, int $offset, int $pageSize): array
    {
        $totalSql = sprintf("SELECT COUNT(*) AS total FROM (%s) as t", $sql);
        $totalRes = DB::select($totalSql);
        $totalCount = $totalRes[0]->total;

        $sql = stripos($sql, 'limit ') === false ?
            $sql . ' LIMIT ' . $offset . ',' . $pageSize : $sql;

        $list = DB::select($sql);

        return [
            'list' => $list,
            'total' => $totalCount
        ];
    }

    /**
     * @param string $sql
     * @return Generator
     */
    public static function dbCursor(string $sql): Generator
    {
        return Db::cursor($sql);
    }
}
