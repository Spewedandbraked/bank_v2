<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\Models\Friends;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    /**
     * Найти друга из списка, затем в зависимости от статуса дружбы выполнить действия.
     */
    private function friendParse(object $takenUser, $casePending, $caseDeclined, $casePester, $caseDefault)
    {
        $friendRecord = Friends::with('friendsStatesOfMine', 'friendStatesOf')
            ->where('user_id', '=', Auth::user()->id)->where('friend_id', '=', $takenUser['id'])
            ->orWhere('friend_id', '=', Auth::user()->id)->where('user_id', '=', $takenUser['id'])
            ->first();

        switch ($friendRecord['state'] ?? null) {
            case 'pending':
                return $casePending($friendRecord, $takenUser);
                break;
            case 'declined':
                return $caseDeclined($friendRecord, $takenUser);
                break;
            case 'pester':
                return $casePester($friendRecord, $takenUser);
                break;
            default:
                return $caseDefault($friendRecord, $takenUser);
                break;
        }
        return back()->withErrors('что то не так. напишите мне на Spewedandbraked@gmail.com');
    }
    public function index()
    {
        $friends = Auth::user()->mergeStatesFriends();

        return view('dashboard', [
            'friends' => $friends,
        ]);
    }
    public function addFriend(FriendRequest $request)
    {
        $email = $request->validated()['email'];
        $takenUser = User::where('email', '=', $email)->first();
        return $this->friendParse(
            $takenUser,
            //if pending
            function ($friendRecord, $takenUser) {
                if ($friendRecord['user_id'] == Auth::user()->id) {
                    return back()->withErrors('вы уже отправили запрос в друзья');
                }
                $friendRecord->state = 'pester';
                $friendRecord->save();
                return back()->withSuccess('УРА ВЫ ДРУЗЬЯ!!!');
            },
            //if declined
            function ($friendRecord, $takenUser) {
                return back()->withErrors('он передал вам 🖕');
            },
            //if already accepted (pester)
            function ($friendRecord, $takenUser) {
                return back()->withErrors('вы уже друзья');
            },
            //default task
            function ($friendRecord, $takenUser) {
                Friends::create([
                    'user_id' => Auth::user()->id,
                    'friend_id' => $takenUser['id'],
                ]);
                return back()->withSuccess('запрос в друзья отправлен!');
            }
        );
    }
    public function blockFriend(FriendRequest $request)
    {
        $email = $request->validated()['email'];
        $takenUser = User::where('email', '=', $email)->first();
        return $this->friendParse(
            $takenUser,
            //if pending
            $blockMan = function ($friendRecord, $takenUser) {
                $friendRecord->user_id = Auth::user()->id;
                $friendRecord->friend_id = $takenUser['id'];
                $friendRecord->state = 'declined';
                $friendRecord->save();
                return back()->withSuccess('УРА ВЫ заблокировали человека!!!');
            },
            //if declined
            function ($friendRecord, $takenUser) {
                if ($friendRecord['user_id'] == Auth::user()->id) {
                    return back()->withErrors('вы уже заблокировали человечка');
                }
                return back()->withErrors('вы были заблокированы этим мужиком');
            },
            //if already accepted (pester)
            $blockMan,
            //default task
            $blockMan
        );
    }
}
