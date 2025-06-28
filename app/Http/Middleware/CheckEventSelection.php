<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckEventSelection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log::info('CheckEventSelection');
        if (config('mds.check_event_selection')) {
            // Log::info('CheckEventSelection: Checking event selection: '. session()->has('EVENT_ID'));
            if (!session()->has('EVENT_ID') && auth()->check()) {
                if (auth()->user()->is_admin) {
                    session()->put('EVENT_ID', 11);
                    return redirect()->route('vapp.admin.booking');
                } elseif (auth()->user()->hasRole('Agency')) {
                    return redirect()->route('cms.agency.orders.pick');
                } elseif (auth()->user()->hasRole('Caterer')) {
                    return redirect()->route('cms.caterer.orders.pick');
                } else {
                    Log::info('CheckEventSelection: Redirecting to pick event');
                    return redirect()->route('cms.contractor.orders.pick');
                }
            }
        }
        return $next($request);
    }
}
