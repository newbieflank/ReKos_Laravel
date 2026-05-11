<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $excludedRoutes = [
            'profile.edit',
            'profile.update',
            'profile.image.update',
            'logout'
        ];

        if ($request->route() && in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        if (auth()->check()) {
            $user = auth()->user();
            $userDetail = $user->userDetail;

            if (!$userDetail || 
                empty(trim((string)$userDetail->phone)) || 
                empty(trim((string)$userDetail->gender)) || 
                $userDetail->gender === 'unknown' || 
                empty(trim((string)$userDetail->birth_date))) {
                return redirect()->route('profile.edit')->with('error', 'Silakan lengkapi profil Anda terlebih dahulu untuk melanjutkan.');
            }
        }

        return $next($request);
    }
}
