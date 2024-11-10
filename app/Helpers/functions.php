<?php

use \Illuminate\Http\JsonResponse;

if (!function_exists('json')) {

    function json(array $data = []): JsonResponse
    {
        return response()->json($data);
    }
}

if (!function_exists('password')) {
    /**
     * @desc encrypt password
     * @param string $value password
     * @param string $salt
     * @return string
     */
    function password(string $value, string $salt): string
    {
        $value = md5(sha1($salt) . $value);
        return sha1($value);
    }
}

if (!function_exists('isSign')) {
    /**
     * @desc user is logged in
     * @return bool
     */
    function isSign(): bool
    {
        $loginUserInfo = session('admin');

        if (empty($loginUserInfo)) {
            return false;
        }

        $expireTime = $loginUserInfo['login_expire_time'];

        if (($expireTime !== true && $expireTime < time())) {
            request()->session()->forget('admin');
            return false;
        }

        return true;
    }
}
