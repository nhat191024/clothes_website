<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Service\admin\CategoryService;
use App\Service\admin\FoodService;
use App\Service\admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    //
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $allUser = $this->userService->getAll();
        return view('admin.user.user', compact('allUser'));
    }

    public function showAddUser()
    {
        return view('admin.user.add_user');
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'fullname' => 'nullable',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|unique:users,phone',
            'status' => 'required|in:0,1',
        ]);
        $username = $request->username;
        $password = $request->password;
        $fullname = $request->fullname;
        $email = $request->email;
        $phone = $request->phone;
        $status = $request->status;
        $this->userService->add($username, $fullname, $email, $phone, $password, $status);
        return redirect(route('admin.user.index'))->with('success', 'Thêm người dùng mới thành công');
    }

    public function showEditUser(Request $request)
    {
        $id = $request->id;
        $user = $this->userService->getById($id);
        return view('admin.user.edit_user', compact('id', 'user'));
    }

    public function editUser(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'username' => 'required',
            'email' => 'nullable',
            'phone' => 'nullable',
        ]);
        $id = $request->id;
        $username = $request->username;
        $fullname = $request->fullname;
        $email = $request->email;
        $phone = $request->phone;
        $point = $request->point;
        $password = $request->password;
        $status = $request->status;

        if ($request->avt) {
            $imageName = time() . '_' . $request->avt->getClientOriginalName();
            $request->avt->move(public_path('img/user'), $imageName);
            $oldImagePath = $this->userService->getById($request->id)->avt;
            if (file_exists(public_path('img/user') . '/' . $oldImagePath)) {
                if($oldImagePath) unlink(public_path('img/user') . '/' . $oldImagePath);
            }
        }

        $this->userService->edit($id, $username, $fullname??null, $email, $phone, $point??null, $password??null, $status??null, $imageName??null);
        return redirect(route('admin.user.index'))->with('success', 'Sửa người dùng thành công');
    }

    public function lockUser(Request $request) {
        $id = $request->id;
        $this->userService->lock($id);
        return redirect(route('admin.user.index'))->with('success', 'Khoá người dùng thành công') ;
    }

    public function unlockUser(Request $request) {
        $id = $request->id;
        $this->userService->unlock($id);
        return redirect(route('admin.user.index'))->with('success', 'Mở khoá người dùng thành công') ;
    }

    public function deleteUser(Request $request) {
        $id = $request->id;
        $this->userService->delete($id);
        return redirect(route('admin.user.index'))->with('success', 'Xoá người dùng thành công') ;
    }
}
