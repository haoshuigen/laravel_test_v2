<?php

namespace App\Http\Trait;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

trait ResponseTrait
{
    /**
     * @desc general response method
     * @param int $code
     * @param array $data
     * @return Response|View|JsonResponse
     */
    public function general(int $code = 0, array $data = []): Response|View|JsonResponse
    {
        if (!isset($data['url'])) {
            $url = request()->ajax() ? '' : 'javascript:history.back(-1);';
        } else {
            $url = (strpos($data['url'], '://') || str_starts_with($data['url'], '/')) ? $data['url'] : "";
        }

        $result = [
            'code'  => $code,
            'msg'   => $data['msg'] ?? '',
            'data'  => $data ?: [],
            'url'   => $url,
            'wait'  => $data['wait'] ?? 3,
            'token' => csrf_token(),
        ];

        if ($this->responseType() == "html") {
            $template = $code == 0 ? 'admin.success' : 'admin.error';
            return response()->view($template, $result);
        }

        return response()->json($result);
    }

    /**
     * get the current response type
     * @access protected
     * @return string
     */
    protected function responseType(): string
    {
        return (request()->ajax() || request()->method() == 'POST') ? 'json' : 'html';
    }

}
