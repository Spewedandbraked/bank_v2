<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\Models\Friends;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function index()
    {
        // dump(Auth::user()->mergePendingFriends('pending'));
        $friends = Auth::user()->mergeStatesFriends();

        return view('dashboard', [
            'friends' => $friends,
        ]);
    }
    public function addFriend(FriendRequest $request)
    {
        $email = $request->validated()['email'];
        $takenUser = User::where('email', '=', $email)->first();
        $friendRecord = Friends::with('friendsStatesOfMine', 'friendStatesOf')
            ->where([['user_id', '=', Auth::user()->id], ['friend_id', '=', $takenUser['id']]])
            ->orWhere([['friend_id', '=', Auth::user()->id], ['user_id', '=', $takenUser['id']]])
            ->first();

        switch ($friendRecord['state'] ?? null) {
            case 'pending':
                if ($friendRecord['user_id'] == Auth::user()->id) {
                    return back()->withErrors('вы уже отправили запрос в друзья');
                }
                $friendRecord->state = 'pester';
                $friendRecord->save();
                return back()->withSuccess('УРА ВЫ ДРУЗЬЯ!!!');
                break;
            case 'declined':
                return back()->withErrors('он передал вам 🖕');
                break;
            case 'pester':
                return back()->withErrors('вы уже друзья');
                break;
            default:
                Friends::create([
                    'user_id' => Auth::user()->id,
                    'friend_id' => $takenUser['id'],
                ]);
                return back()->withSuccess('запрос в друзья отправлен!');
                break;
        }
        return back()->withErrors('что то не так. напишите мне на Spewedandbraked@gmail.com');
    }
}
