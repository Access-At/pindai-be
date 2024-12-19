<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\ResponseApi;
// use App\Helper\SecureCommunication;
use Illuminate\Http\Request;
use Random\Engine\Secure;
use Symfony\Component\HttpFoundation\Response;


class SignatureHeaderMiddleware
{
    // /**
    //  * Handle an incoming request.
    //  */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if ($request->header('X-BYPASS')) return $next($request);

    //     $signature = $request->header('X-SIGNATURE');
    //     $timestamp = $request->header('X-TIMESTAMP');
    //     $secretKey = env('SECURE_API_KEY');

    //     // Periksa header wajib
    //     if (!$signature && !$timestamp) {
    //         return ResponseApi::statusFatalError()
    //             ->error('Header X-SIGNATURE and X-TIMESTAMP are required.')
    //             ->message('Missing signature or timestamp.')
    //             ->json();
    //     }

    //     // Validasi timestamp (batas waktu maksimal 5 menit)
    //     if (abs(time() - (int) $timestamp) > 300) {
    //         return ResponseApi::statusFatalError()
    //             ->error('The timestamp is out of the valid range of 5 minutes.')
    //             ->message('Timestamp is invalid or expired.')
    //             ->json();
    //     }

    //     // Tambahkan salt ke payload untuk mencegah replay attack
    //     $salt = $request->header('X-SALT') ?? '';
    //     if (!$salt) {
    //         return ResponseApi::statusFatalError()
    //             ->error('Header X-SALT is required.')
    //             ->message('Missing salt.')
    //             ->json();
    //     }

    //     if ($request->isMethod('GET')) {
    //         $payload = $request->getQueryString();
    //     } else {
    //         $payload = $request->getContent();
    //     }

    //     // Buat signature ulang untuk validasi
    //     $expectedPayload = $timestamp . $salt . SecureCommunication::encrypt($payload);
    //     $expectedSignature = hash_hmac('sha256', $expectedPayload, $secretKey);

    //     dd([
    //         $expectedPayload,
    //         $request->header('X-PAYLOAD'),
    //         $payload,
    //         SecureCommunication::encrypt($payload),
    //         $expectedSignature,
    //         // hash_equals($expectedSignature, $signature)
    //     ]);


    //     // Validasi signature
    //     if (!hash_equals($expectedSignature, $signature)) {
    //         return ResponseApi::statusQueryError()
    //             ->error('The provided signature does not match the expected signature.')
    //             ->message('Invalid signature.')
    //             ->json();
    //     }

    //     // Lanjutkan middleware jika validasi sukses
    //     return $next($request);
    // }
}
