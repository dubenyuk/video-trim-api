<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 05.02.2017
 * Time: 17:22
 */
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test()
    {
        return [
            'key' => 'value'
        ];
    }
}