<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Konekt\Acl\Models\Role;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{

    public function index(){
        $roles = Role::all();
        return view('pages.admin.users.index', compact('roles'));
    }

    public function store(NewUserRequest $request){

        try {
            $user = User::create([
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $user->assignRole($request['role']);
            return response()->json(['message' => 'User created']);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to create user', 'reason' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateUserRequest $request){
        try {
            $user = User::where('id', $request->user_id);
            $user->update(
                    [
                        'firstname' => $request['firstname'],
                        'lastname' => $request['lastname'],
                    ]
                );
            $user->first()->syncRoles($request['role']);
            return response()->json(['message' => 'Update successful']);
        }catch (\Exception $e){
            return response()->json(['message' => 'Update failed'], 400);
        }
    }

    public function changePassword(Request $request){
        try {
            $user = User::where('id', $request->user_id);
            $user->update(
                [
                    'password' => Hash::make($request['password']),
                ]
            );
            return response()->json(['message' => 'Update successful']);
        }catch (\Exception $e){
            return response()->json(['message' => 'Update failed'], 400);
        }
    }

    public function deactivate($id)
    {
        try {
            $user = User::find($id);
            $user->is_active = 0;
            $user->save();
            return response()->json(['message' => 'Account Deactivated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Deactivate Account'], 400);
        }
    }

    public function activate($id)
    {
        try {
            $user = User::find($id);
            $user->is_active = 1;
            $user->save();
            return response()->json(['message' => 'Account Activated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Activate Account'], 400);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('users')->where('id', $id)->delete();
//            User::find($id)->delete();
            return response()->json(['message' => 'Account deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Account'], 400);
        }
    }

    public function getUserData($id)
    {
    $user = User::where('id', $id)->first();
    $roles = Role::all();
    $role = $user->getRoleNames()[0];

    $response = ['user' => $user, 'roles' => $roles, 'role' => $role];

    return response()->json(['data'=> $response, 'message' => 'User data loaded']);
    }

    public function getUsersData(Request $request){
        $users = [];
        if($request->type == 1){
            $users = User::all();
        }


        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                return '      <td>
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol" style="padding: 10px;">
                                                        <a style="padding:8px 5px" class="dropdown-item activate_btn" href="#" id="' . $users->id . '" onclick="activate(' . $users->id . ')">Activate <i class="fas fa-check float-right"></i></a>
                                                        <a style="padding:8px 5px" class="dropdown-item deactivate_btn" href="#" id="' . $users->id . '" onclick="deactivate(' . $users->id . ')">Deactivate <i class="fas fa-ban float-right"></i></a>
                                                        <a style="padding:8px 5px" class="dropdown-item"  onclick="edit(' . $users->id . ')">Edit <i class="fas fa-edit float-right"></i></a>
                                                        <a style="padding:8px 5px" class="dropdown-item"  onclick="changepassword(' . $users->id . ')">Change Password <i class="fas fa-user-secret float-right"></i></a>
                                                      
                                                        <a style="padding:8px 5px" class="dropdown-item del_btn" href="#" id="' . $users->id . '" onclick="destroy(' . $users->id .')"><span>Delete</span> <i class="fas fa-trash float-right"></i></a>
 </div></td>';
            })
            ->editColumn('is_active', function ($users) {
                if($users->is_active == 1){
                    return  '<span class="badge badge-success">Active</span>';
                }else{
                    return  '<span class="badge badge-danger">Banned</span>';
                }
            })
            ->addColumn('role', function ($users) {
                return $users->getRoleNames()[0];
            })
            ->rawColumns([ 'action', 'is_active'])
            ->make(true);
    }


}
