<?php

namespace App\Http\Controllers\admin;

use App\Exports\SqlDataExport;
use App\Service\SqlLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Service\DataService;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

/**
 * @desc Admin Dev Controller
 */
class DevController extends BaseController
{
    /**
     * @desc admin index page
     * @return View|JsonResponse
     */
    public function index(): View|JsonResponse
    {
        if (!request()->ajax()) {
            return view('admin/dev/index');
        }

        $postData = request()->post();
        $sql = str_ireplace(
            ['delete', 'update', 'create', 'drop'],
            '',
            addslashes($postData['sql'])
        );

        $offset = $postData['offset'] ?? 0;
        $pageSize = $postData['page_size'] ?? 10;
        $dataType = $postData['data_type'] ?? 'raw';

        return match ($dataType) {
            'raw' => $this->rawDataResponse($sql, $offset, $pageSize),
            'json' => $this->jsonExportResponse($sql),
            'excel' => $this->excelExportResponse($sql),
        };
    }

    /**
     * @desc get raw sql statement result data
     * @param string $sql
     * @param int $offset
     * @param int $pageSize
     * @return JsonResponse
     */
    private function rawDataResponse(string $sql, int $offset = 0, int $pageSize = 10): JsonResponse
    {
        try {
            $dbData = DataService::getData($sql, $offset, $pageSize);
            $dbData = $dbData ? json_decode(json_encode($dbData), true) : [];
            $cols = !empty($dbData['list']) && isset($dbData['list'][0]) ?
                array_keys($dbData['list'][0]) : [];

            $list = $dbData['list'];
            $total = $dbData['total'];

            $columnArr = [];
            if (!empty($cols)) {
                foreach ($cols as $col) {
                    $columnArr[] = ['field' => $col, 'title' => $col];
                }
            }
            $code = 0;
            $msg = 'ok';
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            $code = 1;
            $columnArr = [];
            $list = [];
            $total = 0;
        }

        return json([
            'code' => $code,
            'msg' => $msg,
            'token' => csrf_token(),
            'data' => $list,
            'cols' => $columnArr,
            'total' => $total,
        ]);
    }

    /**
     * @desc export data to json file
     * @param string $sql
     * @return JsonResponse
     */
    private function jsonExportResponse(string $sql): JsonResponse
    {
        $downloadPath = '';

        try {
            $dbData = DataService::dbCursor($sql);
            $dataArr = [];

            foreach ($dbData as $row) {
                $dataArr[] = (array)$row;
            }

            if ($dataArr) {
                $fileName = date('YmdHis') . uniqid() . '.json';
                $code = 0;
                $msg = "ok";
                Storage::disk('public')->put($fileName, json_encode($dataArr, JSON_UNESCAPED_UNICODE));
                $downloadPath = 'export/' . $fileName;
            } else {
                $code = 1;
                $msg = "empty data";
            }
        } catch (Exception $e) {
            $code = 1;
            $msg = $e->getMessage();
            SqlLogService::record($e, $sql);
        }

        $returnData = [
            'code' => $code,
            'msg' => $msg,
            'token' => csrf_token(),
            'data' => $downloadPath,
        ];

        return json($returnData);
    }

    /**
     * @desc export data to excel file
     * @param string $sql
     * @return JsonResponse
     */
    private function excelExportResponse(string $sql): JsonResponse
    {
        try {
            $downloadPath = '';
            $dataExportObj = new SqlDataExport($sql);
            $fileName = date('YmdHis') . uniqid() . '.xlsx';
            Excel::store($dataExportObj, $fileName, 'public');
            $downloadPath = 'export/' . $fileName;
            $code = 0;
            $msg = "ok";
        } catch (Exception $e) {
            $code = 1;
            $msg = $e->getMessage();
        }

        $returnData = [
            'code' => $code,
            'msg' => $msg,
            'token' => csrf_token(),
            'data' => $downloadPath,
        ];

        return json($returnData);
    }
}
