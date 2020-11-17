<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class PermissionController extends Controller
{
    /**
     * CRUD of permissions
     */
    // list of permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('pages.permissions.index',compact('permissions'));
    }

    // add permission page
    public function add()
    {
        return view('pages.permissions.add');
    }

    //create permission
    public function create(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:permissions'
        ]);

        Permission::create([
            'name' => $request->get('name'),
            'title' => $request->get('title')
        ]);

        return redirect()->route('permissionIndex');
    }

    // edit page
    public function edit($id)
    {
        $permission = Permission::findById($id);

        return view('pages.permissions.edit',compact('permission'));
    }

    // update data
    public function update(Request $request,$id)
    {
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

        return redirect()->route('permissionIndex');
    }

    // delete permission
    public function destroy($id)
    {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect()->back();
    }
}
