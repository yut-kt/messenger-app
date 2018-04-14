<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        return view('friend_register');
    }

    /**
     * @param Request $request
     * 友達登録
     */
    public function store(Request $request)
    {
        $search_id = $request->input('search_id');
        $user = User::where('search_id', $search_id)->first();

        // search_idが自分のidだった場合
        if ($search_id == Auth::user()->search_id) {
            $request->session()->flash('warning_message', 'It\'s mine');
            return redirect(route('friend.index'));
        }

        // search_idが見つからなかった場合
        if (!$user) {
            $request->session()->flash('warning_message', 'Not find ID');
            return redirect(route('friend.index'));
        }

        // search_idがすでに友達の場合
        $friend_confirm = Friend::where('user_id', Auth::id())->where('to_user_id', $user->id)->first();
        if ($friend_confirm) {
            $request->session()->flash('warning_message', 'already friend');
            return redirect(route('friend.index'));
        }

        // 友達の登録
        $friend = new Friend;
        $friend->user_id = Auth::id();
        $friend->to_user_id = $user->id;
        $friend->save();
        $request->session()->flash('success_message', 'Success register friend');

        return view('friend_register');
    }
}
