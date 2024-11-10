<?php

namespace App\Http\Controllers\admin;

use App\Service\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Webman\Captcha\CaptchaBuilder;
use Webman\Captcha\PhraseBuilder;

/**
 * @Desc Login Class
 */
class LoginController extends BaseController
{
    /**
     * @desc return login page
     * @return Response|View|JsonResponse
     */
    public function index(): Response|View|JsonResponse
    {
        if (isSign()) {
            return $this->general(0, [
                'url' => url('admin/index/index'),
                'msg' => 'you are logged in already'
            ]);
        }

        if (!request()->ajax()) return view('admin.login');

        $post = request()->post();

        Validator::extend('captcha', function ($field, $value) {
            return $value === request()->session()->get('captcha');
        });

        $rules = [
            'username' => 'required|max:20',
            'password' => 'required',
            'code' => 'required|captcha',
        ];

        $validator = Validator::make($post, $rules, [
            'username.required' => 'username must be not empty',
            'username.max' => 'username length no more than 20',
            'password.required' => 'password must be not empty',
            'code.required' => 'captcha must be not empty',
            'code.captcha' => 'captcha not right',
        ]);

        if ($validator->fails()) {
            return $this->general(1, [
                'msg' => $validator->errors()->first()
            ]);
        }

        $loginServiceObj = new LoginService();
        $loginServiceObj->doLogin($post['username'], $post['password'], $post['remember'] ?? 0);
        $loginError = $loginServiceObj->getError();

        if (empty($loginError)) {
            return $this->general(0, [
                'msg' => 'login succeeded, welcome back!',
                'data' => $loginServiceObj->getAdminData()
            ]);
        } else {
            return $this->general(1, [
                'msg' => $loginError,
            ]);
        }
    }

    public function captcha(): Response
    {
        $length = 4;
        $chars = '0123456789';
        $phrase = new PhraseBuilder($length, $chars);
        $builder = new CaptchaBuilder(null, $phrase);
        $builder->build();
        $img_content = $builder->get();
        session()->put('captcha', strtolower($builder->getPhrase()));
        return response($img_content, 200, ['Content-Type' => 'image/jpeg']);
    }

    /**
     * @desc logout method
     * @return Response|JsonResponse|View
     */
    public function logout(): Response|JsonResponse|View
    {
        if (isSign()) {
            request()->session()->forget('admin');
            Cache::forget('navbarMenus_' . session('admin.id'));
        }

        return $this->general(0, [
            'msg' => 'logout done!',
            'url' => url('login')
        ]);
    }
}
