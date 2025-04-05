<?php

namespace Mostafaelashhab\SmartResponse;

use Illuminate\Pagination\AbstractPaginator;

class SmartResponse
{
    public static function createResponse($message = null, $data = null, $status = null)
    {
        // التأكد من أن البيانات paginated
        $isPaginated = $data instanceof AbstractPaginator;

        // إذا لم يتم تحديد الحالة، نختارها تلقائيًا بناءً على نوع البيانات
        if (!$status) {
            $status = $isPaginated || !empty($data) ? 200 : 400;
        }

        // تحديد نوع الاستجابة (success أو error)
        $type = $status >= 200 && $status < 300 ? 'success' : 'error';

        // إرجاع الرسالة بناءً على الترجمة أو الرسالة الافتراضية
        $message = $message ?? __('smart-response::messages.' . $type);

        // إرجاع الـ response بشكل موحد
        return [
            'status' => $type,
            'message' => $message,
            'data' => $data,
            'code' => $status,
        ];
    }
}
