<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Service\DataService;

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

        return $this->rawDataResponse($sql, $offset, $pageSize);
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
        $dbData = DataService::getData($sql, $offset, $pageSize);
        $dbData = $dbData ? json_decode(json_encode($dbData), true) : [];
        $cols = !empty($dbData['list']) && isset($dbData['list'][0]) ?
            array_keys($dbData['list'][0]) : [];

        $columnArr = [];
        if (!empty($cols)) {
            foreach ($cols as $col) {
                $columnArr[] = ['field' => $col, 'title' => $col];
            }
        }

        return json([
            'code'  => 0,
            'msg'   => 'ok',
            'token' => csrf_token(),
            'data'  => $dbData['list'],
            'cols'  => $columnArr,
            'total' => $dbData['total'],
        ]);
    }
}
