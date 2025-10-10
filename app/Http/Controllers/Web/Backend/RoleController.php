<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request){
        $roles = Role::all();
        if($request->ajax()){
            return DataTables::of($roles)
                ->addIndexColumn() // generates the index
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('backend.role.edit',$row->id).'" class="btn btn-sm btn-primary">Edit</a> ';
                    return $btn;
                })
                ->rawColumns(['action']) // allow HTML buttons
                ->make(true);
        }
        return view("backend.layout.roles.index",compact("roles"));
    }

    public function create(Request $request){
        return view('backend.layout.roles.create');
    }

    
    public function edit(Role $role){
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        return view('backend.layout.roles.form', compact('role', 'rolePermissions', 'permissions'));
    }
}
