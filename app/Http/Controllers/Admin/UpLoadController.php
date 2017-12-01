<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpLoadController extends Controller
{
    public function upImages(Request $request)
    {
        $accessKey = '3136Ei-LKgHcCJbHfDTILYdbRwD1sOx0TGncVKQN';
        $secretKey = '020qYeK2kHnL53aP_3bsrzwI1MCxXO7gy2BTy_C2';
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
    }
}
