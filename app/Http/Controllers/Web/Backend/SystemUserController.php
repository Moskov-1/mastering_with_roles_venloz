<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\User;
use App\Rules\PasswordRule;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Contracts\DataTable;

class SystemUserController extends Controller
{
    public function index(Request $request){
        $users = User::where('is_admin_user', 1)->orderBy('id','desc')->paginate(10);
        if($request->ajax()){
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('roles', function ($user) {
                return $user->getRoleNames()
                    ->map(fn($role) => "<span class='badge bg-primary'>$role</span>")
                    ->implode(' ');
            })
            ->addColumn('status', function ($data) {
                $backgroundColor  = $data->status == $data->status ? '#4CAF50' : '#ccc';
                $sliderTranslateX = $data->status == $data->status ? '26px' : '2px';
                
                return getStatusHTML($data, $backgroundColor, $sliderTranslateX);
            })
            ->addColumn('action', function ($data) {
                return '
                <button onclick="edit(' . $data->id . ')" type="button" class="btn btn-info btn-sm">
                    <i class="mdi mdi-pencil"></i>
                </button>
                <button type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger btn-sm del">
                    <i class="mdi mdi-delete"></i>
                </button>
            ';
            })
            ->rawColumns(['name', 'email', 'roles', 'status', 'action'])
            ->make(true);
        }
        return view('backend.layout.users.system_users.index');
    }
    public function create(){
        return view('backend.layout.users.system_users.form');
    }
    public function store(UserRequest $request){
        $data = $request->validated();

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->is_admin_user = $data['is_admin_user'];
        $user->password = bcrypt($data['password']);
        $user->save();

        return redirect()->route('backend.system-user.index')->with('success','System User Successfully created');
    }

    public function edit(User $system_user){
        return view('backend.system-user.form', compact('system_user'));
    }

    
    public function update(Request $request, User $system_user){
        $request->validate([
            'name' => 'required',
            'email'=> 'required|unique:users,email',
            'password' => [['required', new PasswordRule]],
        ]);
        try {
            if(is_null($request['password'])){
                $system_user->password = bcrypt($request['password']);
                $system_user->update();
            }
            $data = $request->only(['name','email']);
            $system_user->update($data);
            
        } catch (\Exception $e) {
            return redirect()->route('backend.system-user.index')->with('error','System User Failed to create');
        }
        return redirect()->route('backend.system-user.index')->with('success','System User Successfully created');
    }

    public function destroy(User $system_user){
        try {
            $system_user->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('backend.system-user.index')->with('success','System User Successfully deleted');
    }
}
