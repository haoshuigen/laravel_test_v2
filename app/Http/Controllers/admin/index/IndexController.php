<?php

namespace App\Http\Controllers\admin\index;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\BaseController;
use Illuminate\View\View;

/**
 * @desc Admin Index Controller
 */
class IndexController extends BaseController
{
    /**
     * @desc admin index page
     * @return View
     */
    public function index(): View
    {
        return view('admin/index/index', [
            'username' => session('admin.username')
        ]);
    }
}
