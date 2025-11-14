<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionsController extends Controller
{
    public function selectionSession()
    {
        $data = session('selection');

        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(false);
        }
    }

    public function selectionSessionRemoved()
    {
        Session::put('selection', false);

        return response()->json(true);
    }
}
