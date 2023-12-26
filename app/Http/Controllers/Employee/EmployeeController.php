<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Service\Employee\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }


    public function createEmployee(Request $request): JsonResponse
    {
        $response = $this->employeeService->createEmployee($request->all());

        return response()->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }


    public function setWorkedHours(Request $request): JsonResponse
    {
        $response = $this->employeeService->setWorkedHours($request->all());

        return response()->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }


    public function setWorkedHoursForCurrent(Request $request): JsonResponse
    {
        $params = $request->all();
        $params['employee_id'] = Auth::id();

        $response = $this->employeeService->setWorkedHours($params);

        return response()->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);


    }



}