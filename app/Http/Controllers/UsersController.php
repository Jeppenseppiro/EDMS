<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Department;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        //$users = DB::table('users')->get();
        $users = User::with('getCompany','getDepartment','getRole')->get();
        $roles = Role::where('id', '!=', '1')->get();
        $companies = Company::get();
        $departments = Department::where('status', '=', 'Active')->get();
        return view('users.users',
            array(
                'users' => $users,
                'companies' => $companies,
                'departments' => $departments,
                'roles' => $roles,
            )
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //reference this validation when different form field name against column name 'email2' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // dd($request->all());
        $userAccount = new User;
        $userAccount->name = $request->name;
        $userAccount->email = $request->email;
        $userAccount->password = bcrypt($request->password);
        $userAccount->company = $request->company;
        $userAccount->department = $request->department;
        $userAccount->role = implode(",", $request->role);
        // dd($userRoles);
        $userAccount->save();
        //

        return redirect()->back();
    }
}