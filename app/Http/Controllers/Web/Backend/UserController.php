<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
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
            ->rawColumns(['name', 'email', 'status', 'action'])
            ->make(true);
        }
    }

    public function store(Request $request){

    }
}
