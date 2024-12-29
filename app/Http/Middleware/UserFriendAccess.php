<?php

namespace App\Http\Middleware;

use App\Models\Friends;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Запрет доступа для заблокированных + вывести данные о пользователе и дружбе.
 */
class UserFriendAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($takenUser = User::where('email', '=', $request->route('selected'))->first()) {
            $selected = Friends::with('friendsStatesOfMine', 'friendStatesOf')
                ->where('user_id', '=', Auth::user()->id)->where('friend_id', '=', $takenUser['id'])
                ->orWhere('friend_id', '=', Auth::user()->id)->where('user_id', '=', $takenUser['id'])
                ->first();
            if (($selected['state'] ?? 'no record') == 'declined' && $selected['user_id'] != Auth::user()->id) {
                return back()->withErrors('лол пользователь заблокал вас :0) мне жаль');
            }
            return $next($request->merge(['selectedFriend' => $selected, 'selectedUser' => $takenUser]));
        }
        return back()->withErrors('пользователя не существует. перенаправление обратно!!!!');
    }
}
