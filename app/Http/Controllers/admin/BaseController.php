<?php

namespace App\Http\Controllers\admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * common method for successful operation
     * @access protected
     * @param string $msg prompt message
     * @param array $data return data
     * @param string|null $url jump url
     * @param int $wait wait time for jumping
     * @return Response|JsonResponse|View
     */
    public function success(string $msg = 'Successful operation!', array $data = [], string $url = null, int $wait = 3): Response|JsonResponse|View
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ($url) {
            $url = (strpos($url, '://') || str_starts_with($url, '/')) ? $url : app('route')->buildUrl($url)->__toString();
        }

        if (empty($url)) {
            $url = url('admin/index'); // 默认跳转到后台首页
        }

        $result = [
            'code'      => 0,
            'msg'       => $msg,
            'data'      => $data,
            'url'       => $url,
            'wait'      => $wait,
        ];

        if ($this->getResponseType() === 'html') {
            return view('admin.success', $result);
        }

        return response()->json($result);
    }

    /**
     * @param string $msg
     * @param array $data
     * @param string|null $url
     * @param int $wait
     * @return Response|JsonResponse|View
     */
    public function error(string $msg = 'Failed operation', array $data = [], string $url = null, int $wait = 3): Response|JsonResponse|View
    {
        if (is_null($url)) {
            $url = request()->ajax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || str_starts_with($url, '/')) ? $url : "";
        }
        $result = [
            'code'      => 1,
            'msg'       => $msg,
            'data'      => $data,
            'url'       => $url,
            'wait'      => $wait,
        ];

        if ($this->getResponseType() === 'html') {
            return view('admin.error', $result);
        }

        return response()->json($result);
    }

    /**
     * return current response output type
     * @access protected
     * @return string
     */
    protected function getResponseType(): string
    {
        return (request()->ajax() || request()->method() == 'POST') ? 'json' : 'html';
    }
}
