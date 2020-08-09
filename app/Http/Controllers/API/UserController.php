<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Create api auth.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $users = User::paginate(2);
    }

    // search input
    public function search(){
      // if condition to check that search input is't empty and the axios request has a q variable
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('type','LIKE',"%$search%");
            })->paginate(2);
        }else{
            $users = User::paginate(2);
        }
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:80',
        'email' => 'required|email|unique:users',
        'type' => 'required',
        'password' => 'required',
      ]);

      return User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'type' => $request['type'],
        'password' => Hash::make($request['password']),
      ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = User::findOrFail($id);
      $request->validate([
        'name' => 'required|string|max:80',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'type' => 'required',
        'password' => 'sometimes',
      ]);
      $request->merge(['password' => Hash::make($request['password'])]);
      $user->update($request->all());
      return ['message' => 'User Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      $user->delete();
      return ['message' => 'User Daleted'];
    }
}
