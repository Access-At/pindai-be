<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\ResponseApi;
use App\Helper\SecureCommunication;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SignatureHeaderMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('X-SIGNATURE');
        $timestamp = $request->header('X-TIMESTAMP');
        $secretKey = env('SECURE_API_KEY');

        // Periksa header wajib
        if (!$signature || !$timestamp) {
            return ResponseApi::statusFatalError()
                ->error('Header X-SIGNATURE and X-TIMESTAMP are required.')
                ->message('Missing signature or timestamp.')
                ->json();
        }

        // Validasi timestamp (batas waktu maksimal 5 menit)
        if (abs(time() - (int) $timestamp) > 300) {
            return ResponseApi::statusFatalError()
                ->error('The timestamp is out of the valid range of 5 minutes.')
                ->message('Timestamp is invalid or expired.')
                ->json();
        }

        // Tambahkan salt ke payload untuk mencegah replay attack
        $salt = $request->header('X-SALT') ?? '';
        if (!$salt) {
            return ResponseApi::statusFatalError()
                ->error('Header X-SALT is required.')
                ->message('Missing salt.')
                ->json();
        }

        // Buat signature ulang untuk validasi
        // $payload = $timestamp . $salt . SecureCommunication::decrypt($request->getContent());
        $payload = $timestamp . $salt . $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, $secretKey);

        // Validasi signature
        if (!hash_equals($expectedSignature, $signature)) {
            return ResponseApi::statusQueryError()
                ->error('The provided signature does not match the expected signature.')
                ->message('Invalid signature.')
                ->data([
                    'fe' => [
                        'x-signature' => $request->header('X-SIGNATURE') ?? '',
                        'x-timestamp' => $request->header('X-TIMESTAMP') ?? '',
                        'x-salt' => $request->header('X-SALT') ?? '',
                        'x-payload' => $request->header('X-PAYLOAD') ?? '',
                    ],
                    'be' => [
                        'x-signature' => $expectedSignature,
                        'x-payload' => $payload,
                    ],
                    'cek' => hash_equals($expectedSignature, $signature),
                    'contentSend' => SecureCommunication::decrypt($request->getContent()),
                ])
                ->json();
        }

        // Lanjutkan middleware jika validasi sukses
        return $next($request);
    }
}
