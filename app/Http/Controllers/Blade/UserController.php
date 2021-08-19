<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // List of users
    public function index()
    {
        abort_if_forbidden('user.show');
        $users = User::where('id','!=',auth()->user()->id)->get();
        return view('pages.user.index',compact('users'));
    }

    // user add page
    public function add()
    {
        abort_if_forbidden('user.add');
        if (auth()->user()->hasRole('Super Admin'))
            $roles = Role::all();
        else
            $roles = Role::where('name','!=','Super Admin')->get();

        return view('pages.user.add',compact('roles'));
    }

    // user create
    public function create(Request $request)
    {
        abort_if_forbidden('user.add');
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

        $activity = "\nCreated by: ".json_encode(auth()->user())
            ."\nNew User: ".json_encode($user)
            ."\nRoles: ".implode(", ",$request->get('roles') ?? []);

        LogWriter::user_activity($activity,'AddingUsers');

        return redirect()->route('userIndex');
    }

    // user edit page
    public function edit($id)
    {
        abort_if((!auth()->user()->can('user.edit') && auth()->id() != $id),403);

        $user = User::find($id);

        if ($user->hasRole('Super Admin') && !auth()->user()->hasRole('Super Admin'))
        {
            message_set("У вас нет разрешения на редактирование администратора",'error',5);
            return redirect()->back();
        }

        if (auth()->user()->hasRole('Super Admin'))
            $roles = Role::all();
        else
            $roles = Role::where('name','!=','Super Admin')->get();

        return view('pages.user.edit',compact('user','roles'));
    }

    // update user dates
    public function update(Request $request, $id)
    {
        abort_if((!auth()->user()->can('user.edit') && auth()->id() != $id),403);

        $activity = "\nUpdated by: ".logObj(auth()->user());
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($id);

        if ($request->get('password') != null)
        {
            $user->password = Hash::make($request->get('password'));
        }

        unset($request['password']);
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
        abort_if_forbidden('user.delete');

        $user = User::destroy($id);
        if ($user->hasRole('Super Admin') && !auth()->user()->hasRole('Super Admin'))
        {
            message_set("У вас нет разрешения на редактирование администратора",'error',5);
            return redirect()->back();
        }
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        DB::table('model_has_permissions')->where('model_id',$id)->delete();
        $deleted_by = logObj(auth()->user());
        $user_log = logObj(User::find($id));
        $message = "\nDeleted By: $deleted_by\nDeleted user: $user_log";
        LogWriter::user_activity($message,'DeletingUsers');
        return redirect()->route('userIndex');
    }

    public function setTheme(Request $request,$id)
    {
        $this->validate($request,[
            'theme' => 'required'
        ]);

        if (!in_array($request->theme,['default','dark','light']))
        {
            message_set("There is no theme like $request->theme!",'warning',3);
        }
        else
        {
            $user = User::findOrFail($id);
            $user->setTheme($request->theme);
            message_set("Theme `$request->theme` is installed!",'success',1);
        }

        return redirect()->back();
    }
}
