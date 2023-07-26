<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    function getData() {
        $users = User::get();

        return response()->json(['status' => true, 'message' => 'Data found', 'data' => $users]);
    }
    function register(UserRequest $request) {
        if($request->id){
            $user = User::where('id',$request->id)->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }
        else{
            $user = User::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Registered Successfully']);
    }

    function delete(Request $request) {
        // dd($request->all());

        $users = User::where('id',$request->id)->first();

        $users->delete();

        return response()->json(['status' => true, 'message' => 'Deleted Successfully']);
    }

    function edit(Request $request) {
        // dd($request->all());

        $users = User::where('id',$request->id)->first();

        return response()->json(['status' => true, 'message' => 'Edited Successfully', 'users' => $users]);
    }
}
