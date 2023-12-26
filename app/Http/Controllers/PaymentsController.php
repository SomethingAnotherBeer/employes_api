<?php
namespace App\Http\Controllers;
use App\Service\PaymentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    private PaymentsService $paymentsService;

    public function __construct(PaymentsService $paymentsService)
    {
        $this->paymentsService = $paymentsService;
    }

    

    public function getAllPaymentsByHours(): JsonResponse
    {
        $response = $this->paymentsService->getAllPaymentsByHours();

        return response()->json($response, 200)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function executeAllPaymentsByHours(): JsonResponse
    {
        $response = $this->paymentsService->executeAllPaymentsByHours();

        $status_code = ($response['status']) ? 201 : 200;

        return response()->json($response, $status_code)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }


}