<?php

namespace Snapshop\Http\Controllers\Admin;

use Snapshop\Models\Admin;
use Snapshop\Models\Role;
use Illuminate\Http\Request;
use Snapshop\Http\Controllers\Controller;

class AdminsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();

        $params = [
            'title' => 'Admins Listing',
            'admins' => $admins,
        ];

        return view('admin.users.users_list')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        $params = [
            'title' => 'Create Admin',
            'roles' => $roles,
        ];

        return view('admin.users.users_create')->with($params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required',
        ]);

        $user = Admin::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $role = Role::find($request->input('role_id'));

        $user->attachRole($role);

        return redirect()->route('admins.index')->with('success', "The user <strong>$user->name</strong> has successfully been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Admin::find($id);

        $params = [
            'title' => 'Delete Admin',
            'user' => $user,
        ];

        return view('admin.users.users_delete')->with($params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Admin::find($id);
        $roles = Role::all();

        $params = [
            'title' => 'Edit Admin',
            'user' => $user,
            'roles' => $roles,
        ];

        return view('admin.users.users_edit')->with($params);
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
        $user = Admin::find($id);

        if (!$user){
            return redirect()
                ->route('admins.index')
                ->with('warning', 'The user you requested for has not been found.');
        }

        $user->email = $request->input('email');

        $user->save();

        $roles = $user->roles;

            foreach ($roles as $key => $value) {
                $user->detachRole($value);
            }

            $role = Role::find($request->input('role_id'));

            $user->attachRole($role);

        return redirect()->route('admins.index')->with('success', "The user <strong>$user->name</strong> has successfully been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Admin::find($id);

        if (!$user){
            return redirect()
                ->route('admins.index')
                ->with('warning', 'The user you requested for has not been found.');
        }

        $user->delete();

        return redirect()->route('admins.index')->with('success', "The user <strong>$user->name</strong> has successfully been archived.");
    }
}
