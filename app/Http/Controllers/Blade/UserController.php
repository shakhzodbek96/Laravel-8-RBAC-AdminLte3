<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // List of users
    public function index()
    {
        $users = User::where('id','!=',auth()->user()->id)->get();
        return view('pages.user.index',compact('users'));
    }

    // user add page
    public function add()
    {
        $roles = Role::all();
        return view('pages.user.add',compact('roles'));
    }

    // user create
    public function create(Request $request)
    {

        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $user->assignRole($request->get('roles'));

        return redirect()->route('userIndex');
    }

    // user edit page
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        return view('pages.user.edit',compact('user','roles'));
    }

    // update user dates
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($id);
        if ($request->get('password') == null)
        {
            unset($request['password']);
        }
        else
        {
            $user->password = Hash::make($request->get('password'));
        }

        $user->fill($request->all());
        $user->save();
        $user->syncRoles($request->get('roles'));
        return redirect()->route('userIndex');
    }

    // delete user by id
    public function destroy($id)
    {
        $user = User::destroy($id);
        return redirect()->route('userIndex');
    }
}
