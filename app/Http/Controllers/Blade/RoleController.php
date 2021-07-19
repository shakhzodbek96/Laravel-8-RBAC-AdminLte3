<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('roles.show');

        if (auth()->user()->hasRole('Super Admin'))
            $roles = Role::with('permissions')->get();
        else
            $roles = Role::where('name','!=','Super Admin')->with('permissions')->get();

        return view('pages.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        abort_if_forbidden('roles.add');

        $this->validate($request,[
            'name' => 'required|unique:roles'
        ]);

        $role = Role::create([
            'name' => $request->get('name'),
            'title' => $request->get('title')
        ]);

        $permissions = $request->get('permissions');
        if ($permissions)
        {
            foreach ($permissions as $key => $item) {
                $role->givePermissionTo($item);
            }
        }

        return redirect()->route('roleIndex');
    }


    public function add()
    {
        abort_if_forbidden('roles.add');
        $permissions = Permission::all();
        return view('pages.roles.add',compact('permissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('roles.edit');
        $role = Role::findById($id);

        abort_if ($role->name == 'Super Admin' && !auth()->user()->hasRole('Super Admin'),403);
        $permissions = Permission::all();

        return view('pages.roles.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        abort_if_forbidden('roles.edit');
        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$id
        ]);
        $permissions = $request->get('permissions');
        unset($request['permissions']);
        $role = Role::findById($id);

        abort_if ($role->name == 'Super Admin' && !auth()->user()->hasRole('Super Admin'),403);

        $role->fill($request->all());
        $role->syncPermissions($permissions);
        $role->save();

        return redirect()->route('roleIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        abort_if_forbidden('roles.delete');
        $role = Role::findById($id);

        if ($role->name == 'Super Admin')
        {
            message_set('You Cannot delete Super Admin Role!','warning',3);
            return redirect()->back();
        }
        DB::table('model_has_roles')->where('role_id',$id)->delete();
        DB::table('role_has_permissions')->where('role_id',$id)->delete();
        $role->delete();
        message_set('Role is deleted','success',3);

        return redirect()->back();
    }
}
