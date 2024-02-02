<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /** Function to getToken */
    public function getToken(){
        $token = "";
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charactersLength = strlen($characters);
        for ($i = 0; $i < 100; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
        
        $Token = new Token();
        $Token->token = $token;
        $Token->save();

        return response()->json([
            "status" => "success",
            "status_code" => 200,
            "token" => $token
        ]);
    }
}
