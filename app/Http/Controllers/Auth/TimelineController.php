<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Tweet;

class TimelineController extends Controller
{
    public function showTimelinePage()
    {
        $tweets = Tweet::latest()->get(); 
        return view('auth.timeline',compact('tweets')); // resource/views/auth/timeline.blade.phpを表示する
    }

    public function postTweet(Request $request)
    {
        $validator = $request->validate([ // バリデーション
            'tweet' => ['required', 'string', 'max:280'], // 必須・文字であること・280文字まで
        ]);
        Tweet::create([ // tweetテーブルに入れる
            'user_id' => optional(Auth::user())->id, // Auth::user()は、現在ログインしている人（つまりツイートしたユーザー）
            'tweet' => $request->tweet, // ツイート内容
            ]);
        return redirect()->back(); // /timelineにリダイレクト
    }
}
