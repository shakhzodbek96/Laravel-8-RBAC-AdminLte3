<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // check if new coming user is first or single
        $cnt = User::count();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($cnt === 0)
        {
            $perms_cnt = Permission::count();

            if ($perms_cnt === 0)
            {
                Permission::insert([
                    ["id" => 1, "name" => 'permission.show', "title" => 'Ruxsatlarni ko\'rish', "guard_name" => 'web'],
                    ["id" => 2, "name" => 'permission.edit', "title" => 'Ruxsatlarni o\'zgartirish', "guard_name" => 'web'],
                    ["id" => 3, "name" => 'permission.add', "title" => 'Yangi ruxsat qo\'shish', "guard_name" => 'web'],
                    ["id" => 4, "name" => 'permission.delete', "title" => 'Ruxsatlarni o\'chirish', "guard_name" => 'web'],
                    ["id" => 5, "name" => 'roles.show', "title" => 'Rollarni ko\'rish', "guard_name" => 'web'],
                    ["id" => 6, "name" => 'roles.edit', "title" => 'Rollarni o\'zgartirish', "guard_name" => 'web'],
                    ["id" => 7, "name" => 'roles.add', "title" => 'Rollar qo\'shish', "guard_name" => 'web'],
                    ["id" => 8, "name" => 'roles.delete', "title" => 'Rollarni o\'chirish', "guard_name" => 'web'],
                    ["id" => 9, "name" => 'user.show', "title" => 'Userlarni ko\'rish', "guard_name" => 'web'],
                    ["id" => 10, "name" => 'user.edit', "title" => 'Userlarni o\'zgartirish', "guard_name" => 'web'],
                    ["id" => 11, "name" => 'user.add', "title" => 'Yangi Userlarni qo\'shish', "guard_name" => 'web'],
                    ["id" => 12, "name" => 'user.delete', "title" => 'Userlarni o\'chirish', "guard_name" => 'web'],
                    ["id" => 13, "name" => 'super.admin', "title" => 'Super Admin', "guard_name" => 'web'],
                ]);
            }

            $role_cnt = Role::count();

            if ($role_cnt === 0)
            {
                $role = Role::create([
                    'id' => 1,
                    'name' => 'Admin',
                    'title' => 'Admin',
                    'guard_name' => 'web'
                ]);

                $permissions = Permission::all();

                foreach ($permissions as $permission) {
                    $role->givePermissionTo($permission->name);
                }
            }

            $user->assignRole('Admin');
        }

        return $user;
    }
}
