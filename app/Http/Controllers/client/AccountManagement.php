<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountManagement extends Controller
{
    // todo: check lich su don hang (bill da thanh toan)
    public function index(){
        $user = Auth::user();
        return view('client.Account.AccountManagement', compact('user'));
    }
    // Fake view
    public function pass(){
        $user = Auth::user();

        return view('client.Account.ChangePassword', compact('user'));
    }
    // Chưa sử dụng
    public function changePass(Request $request){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($request->isMethod('post')) {
            $data = $request->all();
            if(!Hash::check($data['passwordCurrent'],$user->password)){
                return redirect()->route('client.account.changepassword')
                ->with('error', 'Current password is incorrect.');
            }
            $request->validate([
                'passwordNew'=> 'required|min:8',
                'passwordConfirm'=> 'required|same:passwordNew',
            ]);
            if ($data['passwordNew'] == $data['passwordConfirm']) {
                $user->password = bcrypt($data['passwordNew']);
                $user->save();
                return redirect()->route('client.account.index')->with('message', 'Password has been changed successfully.');
            } else {
                return redirect()->route('client.account.changepassword')->with('error', 'Password and Confirm Password does not match.');
            }
        }
    }
    public function changeData(Request $request){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($request->isMethod('post')) {
            $data = $request->all();

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'prefecture' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'building_name' => 'nullable|string|max:255',
                'phone' => ['required', 'regex:/^\d{2}(?:-\d{4}-\d{4}|\d{8}|\d-\d{3,4}-\d{4})$/'],
            ]);

            $imageName = null;
            if ($request->hasFile('avt')) {
                if ($user->avt) {
                    $oldImagePath = public_path('img/user'.$user->avt);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $imageName = str_replace(' ', '', time() . '_' . $request->avt->getClientOriginalName());
                $request->avt->move(public_path('img/user/'), $imageName);
            } else {
                $imageName = $user->avt;
            }

            $user->full_name = $data['name'];
            $user->email = $data['email'];
            $user->prefecture = $data['prefecture'];
            $user->city = $data['city'];
            $user->address = $data['address'];
            $user->building_name = $data['building_name'];
            $user->phone = $data['phone'];
            $user->avt = $imageName;
            $user->save();

            return redirect()->route('client.account.index')->with('message', 'Your info has been updated.');
        }

        return view('client.Account.AccountManagement', compact('user'));
    }

}
