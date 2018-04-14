<?php

namespace App\Http\Controllers;

use App\Message;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($room_id)
    {
        $messages = Message::where('room_id', $room_id)->latest()->forPage(1, 10)->get();
        $messages = $messages->sortBy('created_at');

        // ルームに所属している人数を取得
        $room = Room::where('room_id', $room_id)->whereNotIn('user_id', [Auth::id()])->get();
        $room_count = $room->count();

        if ($room_count == 1) { // 1対1の処理
            $room_name = $room->first()->room_name;
            if (!$room_name) {
                $user_id = $room->first()->user_id;
                $room_name = User::where('id', $user_id)->first()->name;
            }
        } /* else if ($room_count > 1) { // グループの処理
        } else { // エラー処理
        } */

        // 既読処理
        Room::where('room_id', $room_id)->whereNotIn('user_id', [Auth::id()])->update(['read' => true]);

        return view('message', compact('messages', 'room_id', 'room_name'));
    }

    public function load(Request $request, $room_id)
    {
        $load_number = $request->input('load_number');
        \Debugbar::info($load_number);
        $messages = Message::where('room_id', $room_id)->latest()->forPage($load_number, 10)->get();
        return $messages;
    }

    public function store(Request $request)
    {
        $room_id = $request->input('room_id');

        // メッセージを書き込み
        $new_message = new Message;
        $new_message->room_id = $room_id;
        $new_message->user_id = Auth::id();
        $new_message->message = $request->input('message');
        $new_message->save();

        // 未読処理
        Room::where('room_id', $room_id)->where('user_id', Auth::id())->update(['read' => false]);

        return redirect(route('message.show', [$room_id]));
    }
}
