<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(3);

        //dd($users);

        return view('admin.user_index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        return view('admin.user_form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email', //unique utk refer table db mana
            'phone' => 'nullable',
            'role' => 'required|in:user,admin',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new User;

        $user->name = $request['name'];
        $user->email= $request['email'];
        $user->phone= $request['phone'];
        $user->role = $request['role'];

        $user->password = Hash::make($request['password']);

        $user->save();

        return redirect()->route('admin.user.index');
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
        $user = User::find($id);
        return view('admin.user_form', compact('user'));
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
      //dd($request); 
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' .$id, //unique utk refer table db mana
            'phone' => 'nullable',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|min:8|confirmed',
        ]);

       $user = User::find($id);

        $user->name = $request['name'];
        $user->email= $request['email'];
        $user->phone= $request['phone'];
        $user->role = $request['role'];

        if($request['password']){
            $user->password = Hash::make($request['password']);
        }
        
        $user->save();

        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($request); 

        $user = User::find($id);

        $user->delete(); //soft delete
        //$user->forceDelete(); //hard delete

        return redirect()->route('admin.user.index');
    }
}
