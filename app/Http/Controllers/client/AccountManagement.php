<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountManagement extends Controller
{
    public function index($id){
        // $user = auth()->user();
        $user  = User::where('id',$id)->first();
        return view('client.Account.AccountManagement', compact('user'));
    }
    // Fake view
    public function pass($id){
        // $user = auth()->user();
        $user  = User::where('id',$id)->first();
        return view('client.Account.ChangePassword', compact('user'));
    }
    // Chưa sử dụng 
    // public function changePass(Request $request, $id){
    //     $user  = User::where('id',$id)->first();
    //     if ($request->isMethod('post')) {
    //         $data = $request->all();
    //         if ($data['password'] == $data['passwordConfirm']) {
    //             $user->password = bcrypt($data['password']);
    //             $user->save();
    //             return redirect()->route('client.account.index', $id)->with('success', 'Password has been changed successfully.');
    //         } else {
    //             return redirect()->route('client.account.index', $id)->with('error', 'Password and Confirm Password does not match.');
    //         }
    //     }
    // return view('client.Account.changeData', compact('user'));
    //     return view('client.Account.AccountManagement', compact('user'));
    // public function changeData(Request $request, $id){
    //     $user  = User::where('id',$id)->first();
    //     if ($request->isMethod('post')) {
    //         $data = $request->all();
    //         $user->name = $data['name'];
    //         $user->email = $data['email'];
    //         $user->address = $data['address'];
    //         $user->phone = $data['phone'];
    //         $user->save();
    //         return redirect()->route('account.index', $id)->with('success', 'Info has been changed successfully.');
    //     }
    //     return view('client.Account.AccountManagement', compact('user'));    
    // }
}
