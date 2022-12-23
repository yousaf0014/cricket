<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use session;

class UserController extends Controller
{
    public function __construct() {
    /**
     * Set the database connection. reference app\helper.php
     */      
          //selectDatabase();
    }
    /**
     * Display a listing of the Users.
     *
     * @return User List page view
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'users';

        $role =  DB::table('security_role')->get();
        $role_name = array();
        foreach ($role as $value) {
            $role_name[$value->id] = $value->role;
        }

        $data['role_name'] = $role_name;
        $data['userData'] = DB::table('users')->orderBy('id', 'desc')->get();
        
        return view('admin.user.user_list', $data);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return User cerate page view
     */
    public function create()
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'users';

        $data['roleData'] = DB::table('security_role')->get();
        
        return view('admin.user.user_add', $data);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User List page view
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users,email',
            'real_name' => 'required',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        $data['email'] = $request->email;
        $data['user_id'] = $request->real_name;
        $data['real_name'] = $request->real_name;
        $data['password'] = \Hash::make($request->password);
        $data['role_id'] = $request->role_id;
        $data['phone'] = $request->phone;
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $id = DB::table('users')->insertGetId($data);
        if (!empty($id)) {
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('users');
        }
    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int  $id
     * @return User edit page view
     */
    public function edit($id)
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'users';
        
        $data['roleData'] = DB::table('security_role')->get();
        $data['userData'] = DB::table('users')->where('id', '=', $id)->first();
        
        return view('admin.user.editProfile', $data);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return User List page view
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'real_name' => 'required',
            'role_id' => 'required',
        ]);


        $data['user_id'] = $request->real_name;
        $data['real_name'] = $request->real_name;
        $data['role_id'] = $request->role_id;
        $data['phone'] = $request->phone;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $pic = $request->file('picture');

        if (isset($pic)) {
          $upload = 'public/uploads/userPic';

          $pic1 = $request->pic;
          if ($pic1 != NULL) {
            $dir = public_path("uploads/userPic/$pic1");
            if (file_exists($dir)) {
               unlink($dir);  
            }
          }

          $filename = $pic->getClientOriginalName();  
          $pic = $pic->move($upload, $filename);
          $data['picture'] = $filename;
        }
        
        DB::table('users')->where('id', $id)->update($data);
        
            \Session::flash('success',trans('message.success.update_success'));
            return redirect()->intended("edit-user/$id");
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int  $id
     * @return User List page view
     */
    public function destroy($id)
    {
        if(isset($id)) {
            $record = \DB::table('users')->where('id', $id)->first();
            if($record) {
                
                \DB::table('users')->where('id', '=', $id)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('users');
            }
        }
    }

    /**
     * Validate email address while creating a new User.
     *
     * @return true or false
     */
    public function validEmail()
    {
        $email = $_POST['email'];
        $v = DB::table('users')->where('email', '=', $email)->first();
        if (!empty($v)) {
             echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * Show and manage user profile CRUD opration 
     *
     * @return User profile page view
     */
    public function profile()
    {
        $id = Auth::user()->id;
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'profile';
        $data['header'] = 'profile';
        $data['breadcrumb'] = 'profile';
        $data['userData'] = DB::table('users')->where('id', '=', $id)->first();
        $data['roleData'] = DB::table('security_role')->get();

        return view('admin.user.editProfile', $data);
    }

    /**
     * show user change password operation
     *
     * @return change password page view
     */
    public function changePassword($id)
    {
        $data['menu'] = 'NULL';
        $data['header'] = 'profile';
        $data['breadcrumb'] = 'change/password';
        $data['userData'] = DB::table('users')->where('id', '=', $id)->first();

        return view('admin.user.change_password', $data);
    }

    /**
     * Change user password operation perform
     *
     * @return change password page view
     */

    public function updatePassword(Request $request, $id)
    {
         $this->validate($request, [
            'old_pass' => 'required',
            'new_pass' => 'required',
        ]);


        $v = DB::table('users')->where('id', '=', $id)->first();
        
        $data['password'] = \Hash::make($request->new_pass);
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if (\Hash::check($request->old_pass, $v->password)) {
            DB::table('users')->where('id', $id)->update($data);
            \Session::flash('success','Password Update successfully !');
                return redirect()->intended("change-password/$id");
        } else {

            return back()->withInput()->withErrors(['email' => "Old Password is Wrong !"]);
        }

    }
}
