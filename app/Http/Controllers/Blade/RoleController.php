<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('roles.show'))
            return abort(404);

        $roles = Role::with('permissions')->get();
        return view('pages.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        if (!auth()->user()->can('roles.add'))
            return abort(404);

        $permissions = Permission::all();
        return view('pages.roles.add',compact('permissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('roles.edit'))
            return abort(404);

        $role = Role::findById($id);
        $permissions = Permission::all();

        return view('pages.roles.edit',compact('role','permissions'));
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
        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$id
        ]);
        $permissions = $request->get('permissions');
        unset($request['permissions']);
        $role = Role::findById($id);
        $role->fill($request->all());
        $role->syncPermissions($permissions);
        $role->save();

        return redirect()->route('roleIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('roles.delete'))
            return abort(404);
        $role = Role::findById($id);
        $role->delete();
        return redirect()->back();
    }
}
