<?php

namespace Mostafaelashhab\SmartResponse;

use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Http\JsonResponse;

class ResponseMacroRegistrar
{
    public static function register(): void
    {
        Response::macro('smart', function ($message = null, $data = null, $status = null): JsonResponse {
            // لو البيانات paginated
            $isPaginated = $data instanceof AbstractPaginator;

            // لو status مش متحدد، نختار تلقائيًا بناءً على نوع البيانات
            if (!$status) {
                $status = $isPaginated || !empty($data) ? 200 : 400;
            }

            // نحدد هل هي success أو error بناءً على status code
            $type = $status >= 200 && $status < 300 ? 'success' : 'error';

            // بنرجّع البيانات بشكل موحد
            return response()->json([
                'status' => $type,
                'message' => $message ?? __('smart-response::messages.' . $type),
                'data' => $data,
                'code' => $status,
            ], $status);
        });
    }
}
