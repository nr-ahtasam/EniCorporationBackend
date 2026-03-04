<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function show()
    {
        return response()->json([
            'logo_url' => asset('logo/logo.png'), // Update path as needed
            'contact_number' => '+1234567890', // Update with your contact number
        ]);
    }
}
