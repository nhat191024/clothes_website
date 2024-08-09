<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountManagement extends Controller
{
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
            if(!Hash::check($data['passwordCurent'],$user->password)){
                return redirect()->route('client.account.changepassword')
                ->with('error', 'Current password is incorrect.');
            }
            if ($data['passwordNew'] == $data['passwordConfirm']) {
                $user->password = bcrypt($data['passwordNew']);
                $user->save();
                return redirect()->route('client.account.index')->with('success', 'Password has been changed successfully.');
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
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:10',
            ]);
    
            $user->full_name = $data['name'];
            $user->email = $data['email'];
            $user->address = $data['address'];
            $user->phone = $data['phone'];
            $user->save(); 
    
            return redirect()->route('client.account.index')->with('success', 'Update Info Success.');
        }
    
        return view('client.Account.AccountManagement', compact('user'));   
    }
    
}
