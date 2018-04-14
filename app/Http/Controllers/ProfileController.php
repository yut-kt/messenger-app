<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function store(Request $request)
    {
        // search_idのバリデーション処理
        $validator = Validator::make($request->all(), [
            'search_id' => 'required|unique:users|max:191',
        ], ['unique' => 'already use']);

        // バリデーションエラー時リダイレクト
        if ($validator->fails()) {
            return redirect(route('profile.index'))
                ->withErrors($validator)
                ->withInput();
        }

        // search_idの登録
        $user = Auth::user();
        $user->search_id = $request->input('search_id');
        $user->save();

        return view('profile');
    }
}
