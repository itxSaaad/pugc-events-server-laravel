<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Send a successful response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    public function sendResponse(
        mixed $data,
        string $message = 'Success',
        int $statusCode = 200,
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode, $headers);
    }

    /**
     * Send an error response.
     *
     * @param string $error
     * @param int $statusCode
     * @param mixed|null $data
     * @param array $headers
     * @return JsonResponse
     */
    public function sendError(
        string $error,
        int $statusCode = 404,
        mixed $data = null,
        array $headers = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode, $headers);
    }
}
