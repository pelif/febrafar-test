<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function __construct()
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(['helllo' => 'world'], 200);
    }
}
