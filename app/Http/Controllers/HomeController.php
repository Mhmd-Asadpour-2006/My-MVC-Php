<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
//      echo "home controller index";

        $user = new User();
//        $user->insert([
//            'name'=>'ali',
//            'email'=>'ali@admin.com',
//            'password'=>'password234',
//        ]);

//        $result = $user->find(10);
//        var_dump($result->name);

//        $user->find(10)->update([
//            'name' => 'John Doe',
//            'email'=> 'john%admin.com',
//            'password'=>'password1234'
//        ]);

//        $users = $user->get();
//        foreach($users as $user){
//            echo  "<br/>" .$user->name;
//        }

//        $user->delete(14);

//        var_dump($user->where('id','>',14)->get());

//        var_dump($user->orderBy('id','ASC')->get());

//        var_dump($user->limit(0,2)->get());

    }
}