<?php

namespace Fickrr\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Fickrr\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Fickrr\Http\Middleware\TrimStrings::class,
		\Fickrr\Http\Middleware\CheckReferral::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Fickrr\Http\Middleware\TrustProxies::class,
		\Fickrr\Http\Middleware\xframeOptions::class,
		
		
		/*\RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss::class,
		\RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes::class,
		\RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch::class,*/
		/*\RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments::class,
		\RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls::class,
		\RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes::class,
		\RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace::class,*/
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Fickrr\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Fickrr\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
			\Fickrr\Http\Middleware\Localization::class,
			
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Fickrr\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Fickrr\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
		'is_admin' => \Fickrr\Http\Middleware\IsAdmin::class,
        'is_client' => \Fickrr\Http\Middleware\IsClient::class,
		'XSS' => \Fickrr\Http\Middleware\XSS::class,
		'HtmlMinifier' => \Fickrr\Http\Middleware\HtmlMinifier::class,
		'optimizeImages' => \Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages::class,
		'cache' => \Fickrr\Http\Middleware\GlobalCache::class,
		'cacheable'=>\Fickrr\Http\Middleware\CacheResponse::class,
		
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Fickrr\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
