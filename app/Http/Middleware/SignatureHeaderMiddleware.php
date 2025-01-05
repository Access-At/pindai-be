<?php

namespace App\Http\Middleware;

use Closure;
use Random\Engine\Secure;
// use App\Helper\SecureCommunication;
use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SignatureHeaderMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            config('app.env') === 'local' &&
            $request->header('x-bypass')
        ) {
            return $next($request);
        }

        $signature = $request->header('x-signature');
        $timestamp = $request->header('x-timestamp');
        $salt = $request->header('x-salt');

        $secretKey = env('SECURE_API_KEY');

        // Periksa header wajib
        if (!$signature && !$timestamp && !$salt) {
            return ResponseApi::statusFatalError()
                // ->error('Unauthorized: Missing required headers.')
                ->message('Unauthorized: Missing required headers.')
                ->json();
        }

        // Validasi timestamp (batas waktu maksimal 5 menit)
        if (abs(time() - (int) $timestamp) > 300) {
            return ResponseApi::statusFatalError()
                ->message('Timestamp is invalid or expired.')
                ->json();
        }

        $payload = $request->getContent();
        $serverSignature = hash_hmac('sha256', $timestamp . $payload, $secretKey);

        // dd([
        //     'signature' => $signature,
        //     'serverSignature' => $serverSignature,
        //     'data' => $request->header('x-data'),
        //     'payload' => $payload,
        //     'key' => $secretKey
        // ]);

        if (!hash_equals($serverSignature, $signature)) {
            return ResponseApi::statusQueryError()
                ->message('Unauthorized: Invalid signature.')
                ->json();
        }

        return $next($request);
    }
}
