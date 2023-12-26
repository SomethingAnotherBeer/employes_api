<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use App\Service\Employee\EmployeeRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeRateController extends Controller
{
    private EmployeeRateService $employeeRateService;

    public function __construct(EmployeeRateService $employeeRateService)
    {
        $this->employeeRateService = $employeeRateService;
    }



    public function setEmployeeRate(Request $request): JsonResponse
    {
        $response = $this->employeeRateService->setEmployeeRate($request->all());

        return response()->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }


}