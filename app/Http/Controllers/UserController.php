<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Return the user data
        return response()->json([
            'user' => $user,
        ]);
    }

}
