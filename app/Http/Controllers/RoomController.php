<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class RoomController extends Controller
{
    public function index()
    {
        // ルームの一覧を取得
        $my_rooms = Room::where('user_id', Auth::id())->pluck('room_id');
        $user_rooms = Room::whereIn('room_id', $my_rooms)->whereNotIn('user_id', [Auth::id()])->get();
        $user_ids = $user_rooms->pluck('user_id');
        $users = User::whereIn('id', $user_ids)->get();

        return view('room', compact('user_rooms', 'users'));
    }

    public function show($friend_id)
    {
        // friend_idからルームを取得
        $my_rooms = Room::where('user_id', Auth::id())->pluck('room_id');
        $room = Room::where('user_id', $friend_id)->whereIn('room_id', $my_rooms)->first();

        // すでにルームが作られていたらページ遷移
        if ($room) {
            return redirect(route('message.show', [$room->room_id]));
        }

        // ルームが作られていなかった場合登録
        $max_id = Room::pluck('room_id')->max();
        $new_room = new Room;
        $new_room_id = $max_id + 1;
        $new_room->room_id = $new_room_id;
        $new_room->user_id = Auth::id();
        $new_room->save();

        $new_room = new Room;
        $new_room->room_id = $new_room_id;
        $new_room->user_id = $friend_id;
        $new_room->save();

        return redirect(route('message.show', [$new_room_id]));
    }
}
