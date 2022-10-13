<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $list_post = \App\User::join('posts','posts.user_id' , '=', 'users.id')
        ->select('posts.id','posts.user_id','posts.title','posts.description','posts.file','posts.approve_status','posts.updated_at','users.name AS userName','users.id AS userId','users.type AS userType')->where('posts.active_status', 1);
        if(Auth::user()){
            if(Auth::user()->type != 'A'){
                $list_post = $list_post->where('posts.approve_status', 1);
            }
            $list_post = $list_post->orderBy('posts.updated_at', 'desc')->get();
        }else{
            $list_post = $list_post->where('posts.approve_status', 1);
            $list_post = $list_post->orderBy('posts.updated_at', 'desc')->get();  
        }
        $count = count($list_post);
        return view('view_post', compact('list_post', 'count'));
    }
}
