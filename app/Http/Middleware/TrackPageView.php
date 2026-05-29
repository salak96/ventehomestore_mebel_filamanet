<?php

namespace App\Http\Middleware;

use App\Models\VisitorTracking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && ! $request->ajax() && ! $request->is('livewire/*')) {
            $lastVisit = session('last_page_view_time', 0);
            $now = time();

            if (($now - $lastVisit) >= 10) {
                VisitorTracking::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'page_url'   => $request->fullUrl(),
                    'action'     => 'view',
                ]);
                session(['last_page_view_time' => $now]);
            }
        }

        return $response;
    }
}
