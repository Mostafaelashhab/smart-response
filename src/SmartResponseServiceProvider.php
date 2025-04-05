<?php

namespace Mostafaelashhab\SmartResponse;

use Illuminate\Support\ServiceProvider;

class SmartResponseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // تسجيل الـ macro
        ResponseMacroRegistrar::register();

        // تحميل ملفات الترجمة
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'smart-response');

        // لو حب المستخدم ينشر الترجمة
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/smart-response'),
        ], 'smart-response-translations');
        Response::macro('success', function ($message = null, $data = null, $request = null) {
            return SmartResponse::success($message, $data, $request);
        });

        Response::macro('error', function ($message = null, $data = null, $request = null) {
            return SmartResponse::error($message, $data, $request);
        });
    }

    public function register()
    {
        //
    }
}
