<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\Models\Friends;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function index()
    {
        dump(Auth::user()->mergePendingFriends('pending'));
        $friends = Auth::user()->mergePendingFriends('pending');
        return view('dashboard', [
            'friends' => $friends,
        ]);
    }
    public function addFriend(FriendRequest $request)
    {
        $email = $request->validated()['email'];
        // if (Auth::user()->isRequestAlreadySent($email) != null) {
        //     return back()->withErrors('🖕');
        // }
        // $friend = Auth::user()->isFriendAlreadyPending($email);
        // dd($friend['user_email'], Auth::user()->email);
        // $friend == null ? Friends::sendRequest($email) : ($friend['user_email'] != Auth::user()->email ? $friend->setPendingToPester() : null);

        Friends::sendRequest($email);

        return back()->withSuccess('IT WORKS!');
    }
}
