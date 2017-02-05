<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 05.02.2017
 * Time: 22:08
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $path = $request->video->storeAs('video', 'test.mp4');
        //$res = Storage::put('video', $request->video);
        if($path){
            return response(['msg' => $path], 200);
        }
        return response(['msg' => 'oops'], 500);
    }
}