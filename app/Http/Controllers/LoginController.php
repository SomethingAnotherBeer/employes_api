<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }


    public function login(Request $request): JsonResponse
    {
        $response = $this->loginService->login($request->all());
        
        return response()->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }   

}
