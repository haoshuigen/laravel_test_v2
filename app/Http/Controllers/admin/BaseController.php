<?php

namespace App\Http\Controllers\admin;

use App\Http\Trait\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ResponseTrait;
}
