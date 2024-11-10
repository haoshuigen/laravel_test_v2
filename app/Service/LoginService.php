<?php

namespace App\Service;

use App\Models\AdminUser;
use App\Models\AdminRole;

/**
 * login service
 * Class LoginService
 * @package app\service\service
 */
class LoginService {
    /**
     * @var string login error message
     */
    private string $error;
    /**
     * @var array admin user data
     */
    private array $adminData;

    public function __construct()
    {
        $this->error = '';
        $this->adminData = [];
    }

    /**
     * @desc login function
     * @param string $username
     * @param string $password
     * @param int   $rememberLogin
     * @return void
     */
    public function doLogin(string $username, string $password, int $rememberLogin):void
    {
        $admin = AdminUser::where(['username' => $username])->first();

        if (empty($admin) || password($password, $admin->salt) != $admin->password) {
            $this->error = 'username or password is not right';
            return;
        }
        if ($admin->disabled === 1) {
            $this->error = 'sorry, your account is disabled';
            return;
        }

        $admin->last_login_time = time();
        $admin->save();
        $admin = $admin->toArray();
        $roleNames = AdminRole::whereIn('id', explode(',', $admin['role_ids']))->pluck('role_name')->toArray();
        $admin['login_expire_time'] = $rememberLogin === 1 ? true : time() + (24 * 3600);
        $admin['role_name'] = implode(',', $roleNames);
        $this->adminData = $admin;
        session(compact('admin'));
    }

    /**
     * @desc return login error
     * @return string
     */
    public function getError():string
    {
        return $this->error;
    }

    /**
     * @desc return user's data
     * @return array
     */
    public function getAdminData():array
    {
        return $this->adminData;
    }
}
