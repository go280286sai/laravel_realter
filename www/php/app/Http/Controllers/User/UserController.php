<?php

namespace App\Http\Controllers\User;

use App\Func\MyFunc;
use App\Http\Controllers\Controller;
use App\Mail\User_email;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::all();

        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
      $validated =  $request->validate([
            "name" => "required|string",
            "birthday" => "nullable|date",
            "email" => "required|string|unique:users",
            "phone" => "required|numeric",
            "gender_id" => "nullable|numeric",
            "description" => "nullable|string",
            "password" => "required|string",
        ]);
        $data = array_map(function ($value) {
            if($value!=""){
                return $value;
            }
        }, $validated);

        User::add($data);

        return redirect('/user/users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = User::find($id);

        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated =  $request->validate([
            "name" => "required|string",
            "birthday" => "nullable|date",
            "phone" => "required|numeric",
            "gender_id" => "nullable|numeric",
            "description" => "nullable|string",
            "password" => "required|string",
        ]);
        $data = array_map(function ($value) {
            if($value!=""){
                return $value;
            }
        }, $validated);
        User::edit($data, $id);

        return redirect('/user/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        User::remove($id);

        return redirect('/user/users');
    }

    public function comment(string $id): View
    {
        $object = User::find($id);

        return view('admin.user.comment', ['object' => $object]);
    }

    public function add_comment_user(Request $request): RedirectResponse
    {
        $fields = MyFunc::stripTags($request->all());
        User::add_comment_user($fields);

        return redirect('/user/users');
    }

    /**
     * @param int $id
     * @return View
     */
    public function createMessage(int $id): View
    {
        $user = User::find($id);

        return view('admin.user.mail', ['user' => $user]);
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'title' => 'required|string',
            'email' => 'required|string',
        ]);
        $fields = MyFunc::stripTags($validated);
        Mail::to($fields['email'])->cc(Auth::user()->email)->send(new User_email($fields));
        Log::info('Answer the message: '.$fields['email'].' '.$fields['title'].' --'.Auth::user()->name);

        return redirect('/user/users');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photo' => 'image|max:1024']);
        User::updateProfilePhotoUser($request->file('photo'));

        return redirect()->back();
    }


}
