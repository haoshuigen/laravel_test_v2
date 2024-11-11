<?php

namespace App\Http\Controllers\admin;

use Illuminate\View\View;

/**
 * @desc Admin Dev Controller
 */
class DevController extends BaseController
{
    /**
     * @desc admin index page
     * @return View
     */
    public function index(): View
    {
        return view('admin/dev/index');
    }
}
