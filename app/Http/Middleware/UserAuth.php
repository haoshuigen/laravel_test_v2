<?php

namespace App\Http\Middleware;

use App\Http\Trait\ResponseTrait;
use App\Service\MenuService;
use Closure;
use Illuminate\Http\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserAuth
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Closure(HttpRequest): (HttpResponse) $next
     */
    public function handle(HttpRequest $request, Closure $next): HttpResponse
    {
        $adminUserInfo = session('admin');
        if (empty($adminUserInfo)) {
            return $this->general(1, [
                'msg' => 'please login first!',
                'url' => url("/login")
            ]);
        }

        $expireTime = $adminUserInfo['login_expire_time'];
        // 判断是否登录过期
        if ($expireTime !== true && time() > $expireTime) {
            $request->session()->forget('admin');
            return $this->general(1, [
                'msg' => 'your session is expired,please log in!',
                'url' => url("/login")
            ]);
        }

        // 验证权限
        $routePath = ltrim(str_replace(request()->getSchemeAndHttpHost(), '', request()->url()), '/');
        $authCheckRes = (new MenuService())->checkNodeAuth($routePath);

        if (!$authCheckRes) {
            return $this->general(1, [
                'msg' => 'Sorry,you have no access to this route!',
                'url' => url("/admin/index/index")
            ]);
        }

        return $next($request);
    }
}
