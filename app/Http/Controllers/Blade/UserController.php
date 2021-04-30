<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // List of users
    public function index()
    {
        if (!auth()->user()->can('user.show'))  return abort(403);

        $users = User::where('id','!=',auth()->user()->id)->get();

        return view('pages.user.index',compact('users'));
    }

    // user add page
    public function add()
    {
        if (!auth()->user()->can('user.add')) return abort(403);

        $roles = Role::all();

        if (!auth()->user()->can('super.admin'))
            $roles = $roles->where('name','!=','Admin')->all();

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

        $activity = "\nCreator: ".json_encode(auth()->user())
            ."\nNew User: ".json_encode($user)
            ."\nRoles: ".implode(", ",$request->get('roles'));

        LogWriter::user_activity($activity,'AddingUsers');

        return redirect()->route('userIndex');
    }

    // user edit page
    public function edit($id)
    {
        if (!auth()->user()->can('user.edit') && auth()->user()->id != $id) return abort(403);

        $user = User::find($id);

        if ($user->hasRole('Admin') && !auth()->user()->can('super.admin') && auth()->user()->id != $id)
        {
            message_set("У вас нет разрешения на редактирование администратора",'error',5);
            return redirect()->back();
        }

        $roles = Role::all();

        if (!auth()->user()->can('super.admin'))
            $roles = $roles->where('name','!=','Admin')->all();

        return view('pages.user.edit',compact('user','roles'));
    }

    // update user dates
    public function update(Request $request, $id)
    {
        $activity = "\nUpdater: ".logObj(auth()->user());

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
            unset($request['password']);
        }

        $activity .="\nBefore updates User: ".logObj($user);
        $activity .=' Roles before: "'.implode(',',$user->getRoleNames()->toArray()).'"';

        $user->fill($request->all());
        $user->save();

        if (isset($request->roles)) $user->syncRoles($request->get('roles'));
        unset($user->roles);

        $activity .="\nAfter updates User: ".logObj($user);
        $activity .=' Roles after: "'.implode(',',$user->getRoleNames()->toArray()).'"';

        LogWriter::user_activity($activity,'EditingUsers');

        if (auth()->user()->can('user.edit'))
            return redirect()->route('userIndex');
        else
            return redirect()->route('home');
    }

    // delete user by id
    public function destroy($id)
    {
        if (!auth()->user()->can('user.delete'))
            return abort(403);

        $deleted_by = logObj(auth()->user());
        $user = logObj(User::find($id));
        $message = "\nDeleted By: $deleted_by\nDeleted user: $user";
        LogWriter::user_activity($message,'DeletingUsers');

        $user = User::destroy($id);
        return redirect()->route('userIndex');
    }
}
