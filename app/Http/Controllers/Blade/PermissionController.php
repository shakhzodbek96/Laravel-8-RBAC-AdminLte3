<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * list of permissions
     */
    public function index()
    {
        abort_if_forbidden('permission.show');
        $permissions = Permission::with('roles')->get();
        return view('pages.permissions.index',compact('permissions'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('permission.add');
        return view('pages.permissions.add');
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('permission.add');

        $this->validate($request,[
            'name' => 'required|unique:permissions'
        ]);

        Permission::create([
            'name' => $request->get('name'),
            'title' => $request->get('title')
        ]);
        message_set('New permission is added!','success',2);
        return redirect()->route('permissionIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('permission.edit');
        $permission = Permission::findById($id);
        return view('pages.permissions.edit',compact('permission'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('permission.edit');

        $this->validate($request,[
            'name' => 'required|unique:permissions,name,'.$id
        ]);

        $permission = Permission::findById($id);
        $permission->name = $request->get('name');

        if ($request->has('title'))
        {
            $permission->title = $request->get('title');
        }
        $permission->save();
        message_set('Permission is updated!','success',2);
        return redirect()->route('permissionIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('permission.delete');
        $permission = Permission::findById($id);
        DB::table('model_has_permissions')->where('permission_id',$id)->delete();
        DB::table('role_has_permissions')->where('permission_id',$id)->delete();
        $permission->delete();
        message_set('Permission is deleted!','success',2);
        return redirect()->back();
    }
}
