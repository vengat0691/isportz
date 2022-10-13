<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_post = \App\User::join('posts','posts.user_id' , '=', 'users.id')
        ->select('posts.id','posts.user_id','posts.title','posts.description','posts.file','posts.approve_status','posts.updated_at','users.name AS userName','users.id AS userId','users.type AS userType')->where('posts.active_status', 1);
        if(Auth::user()){
            $list_post = $list_post->orderBy('posts.updated_at', 'desc')->get();
        }else{
            $list_post = $list_post->where('posts.approve_status', 1);
            $list_post = $list_post->orderBy('posts.updated_at', 'desc')->get();  
        }
        $count = count($list_post);
        return view('list_post', compact('list_post', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new \App\Post;
        if ($request->file('image') != '') {
            $image = $request->file('image');
            $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $input['imagename']);
            $post->file = $input['imagename'];
        }
        $post->title = $request->get('title');
        $post->description = $request->get('description');
        $post->type = Auth::user()->type;
        $post->user_id = Auth::user()->id;
        $post->active_status = 1;
        $post->save();

        //mail function starts
        // $to_name = 'Admin';
        // $to_email = 'vengat0691@gmail.com';
        // $data = array('name'=>$to_name, "body" => "I have added post please approve it");
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('isportZ Test Email');
        // $message->from(Auth::user()->email, Auth::user()->name);
        // });
        //mail function ends
        return redirect('listPost')->with('success', 'Post added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_type = Auth::user()->type;
        $user_id = Auth::user()->id;
        $post = \App\Post::find($id);
        if ($user_type == 'A') {
            return view('edit_post', compact('post', 'id'));
        } elseif (($user_type == 'U') && ($post->user_id == $user_id)){
            return view('edit_post', compact('post', 'id'));
        } else {
            return redirect('listPost');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_type = Auth::user()->type;
        $user_id = Auth::user()->id;

            $post = \App\Post::find($id);
        if ($user_type == 'A') {
            if ($request->file('image') != '') {
                $image = $request->file('image');
                $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/img');
                $image->move($destinationPath, $input['imagename']);
                $post->file = $input['imagename'];
            }
            $post->title = $request->get('title');
            $post->description = $request->get('description');
            $post->save();
        //mail function starts
        // $to_name = 'Admin';
        // $to_email = 'vengat0691@gmail.com';
        // $data = array('name'=>$to_name, "body" => "I have updated my post please");
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('isportZ Test Email');
        // $message->from(Auth::user()->email, Auth::user()->name);
        //});
        //mail function ends

            return redirect('listPost')->with('success', 'Post updated successfully');
        }
        if (($user_type == 'U') && ($post->user_id == $user_id)){
            if ($request->file('image') != '') {
                $image = $request->file('image');
                $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/img');
                $image->move($destinationPath, $input['imagename']);
                $post->file = $input['imagename'];
            }
            $post->title = $request->get('title');
            $post->description = $request->get('description');
            $post->save();

        //mail function starts
        // $to_name = 'Admin';
        // $to_email = 'vengat0691@gmail.com';
        // $data = array('name'=>$to_name, "body" => "I have updated my post");
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('isportZ Test Email');
        // $message->from(Auth::user()->email, Auth::user()->name);
        // });
        //mail function ends

            return redirect('listPost')->with('success', 'Post updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_type = Auth::user()->type;
        if ($user_type == 'A') {
            $post = \App\Post::find($id);
            $post->active_status = 0;
            $post->save();
            return redirect('listPost')->with('error', 'Post deleted successfully');
        } else {
            return redirect('listPost');
        }
    }

    /**
     * Admin approve the post.
    */
    public function approvePost(Request $request)
    {
        $post_id=$request->get('id');
        $post= \App\Post::find($post_id);
        $post->approve_status=1;
        $post->save();

        //to get email and name
        $post_details = \App\User::join('posts','posts.user_id' , '=', 'users.id')
        ->select('posts.id','posts.user_id','posts.title','posts.description','posts.file','posts.approve_status','posts.updated_at','users.name AS userName','users.id AS userId','users.type AS userType','users.email AS userEmail')->where('posts.active_status', 1)->where('posts.id', $post_id);
        $post_details = $post_details->orderBy('posts.updated_at', 'desc')->get();

        //mail function starts
        // $to_name = $post_details[0]->userName;
        // $to_email = $post_details[0]->userEmail;
        // $data = array('name'=>$to_name, "body" => "Your post has been approved by admin");
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('isportZ Test Email');
        // $message->from('no-reply@admin.com','Test Mail');
        // });
        //mail function ends

        return redirect('listPost')->with('success', 'Post approved successfully');
    }
}
