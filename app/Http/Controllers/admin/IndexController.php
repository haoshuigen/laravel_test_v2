<?php

namespace App\Http\Controllers\admin;

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
        return view('admin/index/index');
    }
}
