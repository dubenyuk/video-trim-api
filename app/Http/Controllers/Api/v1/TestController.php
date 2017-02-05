<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 05.02.2017
 * Time: 17:22
 */
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test()
    {
        //$user = User::where(['id' => Auth::user()->id])->first();
        //dd(User::find(1)->videos);
        return [
            'data' => User::find(1)->videos
        ];
    }
}