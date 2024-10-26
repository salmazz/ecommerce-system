<?php

namespace App\Common\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseHelper
{
    /**
     * Paginated Json Response
     *
     * Used To Return Paginated Json Data
     * @param string|null $message
     * @param array|null $data
     * @param int|null $code
     * @param string|null $paginatedDataKey
     * @return JsonResponse
     */
    public static function paginatedJsonResponse(
        string|null $message = null,
        array|null $data = null,
        int|null $code = null,
        string|null $paginatedDataKey = null
    ): JsonResponse {
        $code ??= Response::HTTP_OK;
        $paginatedDataKey ??= 'items';
        $message ??= "";

        $responseData = [
            'current_page' => $data[$paginatedDataKey]->currentPage(),
            'data' => $data[$paginatedDataKey]->items(),
            'first_page_url' => $data[$paginatedDataKey]->url(1),
            'from' => $data[$paginatedDataKey]->firstItem(),
            'last_page' => $data[$paginatedDataKey]->lastPage(),
            'last_page_url' => $data[$paginatedDataKey]->url($data[$paginatedDataKey]->lastPage()),
            'next_page_url' => $data[$paginatedDataKey]->nextPageUrl(),
            'path' => $data[$paginatedDataKey]->url(1),
            'per_page' => $data[$paginatedDataKey]->perPage(),
            'prev_page_url' => $data[$paginatedDataKey]->previousPageUrl(),
            'to' => $data[$paginatedDataKey]->lastItem(),
            'total' => $data[$paginatedDataKey]->total(),
        ];

        unset($data[$paginatedDataKey]);
        foreach ($data as $key => $val) {
            $responseData[$key] = $val;
        }

        return response()->json([
            "code" => $code,
            "message" => $message,
            "data" => $responseData
        ], $code);
    }

    /**
     * Json Response
     *
     * Used To Return Json Data
     * @param string|null $message
     * @param array|null $data
     * @param int|null $code
     * @return JsonResponse
     */
    public static function jsonResponse(
        string|null $message = "",
        array|null $data = null,
        int|null $code = null
    ): JsonResponse {
        $code ??= Response::HTTP_OK;
        $message ??= "";

        return response()->json(compact('code', 'message', 'data'), $code);
    }

    /**
     * Error Json Response
     *
     * Used To Return Error Json Data
     * @param string $userMessage
     * @param string $internalMessage
     * @param array|null $moreInfo
     * @param int|null $code
     * @return JsonResponse
     */
    public static function errorResponse(
        string $userMessage,
        string $internalMessage,
        array|null $moreInfo = null,
        int|null $code = null
    ): JsonResponse {
        $code ??= Response::HTTP_BAD_REQUEST;
        $moreInfo ??= [];

        return response()->json([
            "code" => $code,
            "message" => $userMessage,
            "errors" => [
                "error_message" => $internalMessage,
                "error_details" => $moreInfo,
            ]
        ], $code);
    }
}
