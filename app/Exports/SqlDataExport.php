<?php

namespace App\Exports;

use App\Service\SqlLogService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Service\DataService;
use Exception;

class SqlDataExport implements FromCollection
{
    private string $dbSql;

    public function __construct(string $dbSql)
    {
        $this->dbSql = $dbSql;
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        try {
            $dbData = DataService::dbCursor($this->dbSql);
        } catch (Exception $exception) {
            SqlLogService::record($exception, $this->dbSql);
            throw new Exception($exception->getMessage());
        }

        $dataArr = [];
        foreach ($dbData as $row) {
            $dataArr[] = (array)$row;
        }

        if (!empty($dataArr)) {
            $cols = array_keys($dataArr[0]);
            array_unshift($dataArr, $cols);
        } else {
            throw new Exception('no data');
        }

        return collect($dataArr);
    }
}
