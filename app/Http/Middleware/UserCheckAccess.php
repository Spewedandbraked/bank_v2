<?php

namespace App\Http\Middleware;

use App\Models\Check;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 *ПРОШУ ЗАМЕТИТЬ Check НЕ ВСМЫСЛЕ ПРОВЕРИТЬ А ВСМЫСЛЕ СЧЕТ!!!
 */
class UserCheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $selected = Check::where('id', $request->route('selected'))->first();
        if ($selected['author'] != Auth::id()) {
            return back()->withErrors('🖕');
        }
        return $next($request->merge(['selectedCheck' => $selected]));
    }
}
