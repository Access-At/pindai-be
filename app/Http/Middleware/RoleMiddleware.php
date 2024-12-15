<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role, $guard = null)
    {
        try {

            $authGuard = Auth::guard($guard);

            if ($authGuard->guest()) {
                throw UnauthorizedException::notLoggedIn();
            }

            $roles = is_array($role)
                ? $role
                : explode('|', $role);

            if ( ! $authGuard->user()->hasAnyRole($roles)) {
                abort(ResponseApi::statusValidateError()
                    ->error('You don\'t have role access')
                    ->message('Unauthorized')
                    ->info(['auth' => false])
                    ->json());
            }

            return $next($request);
        } catch (Exception $e) {
            abort(ResponseApi::statusValidateError()
                ->error('You don\'t have role access')
                ->message('Unauthorized')
                ->info(['auth' => false])
                ->json());
        }
    }
}
