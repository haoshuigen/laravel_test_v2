<?php

namespace App\Http\Controllers\admin;

use App\Http\Trait\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ResponseTrait;
}
