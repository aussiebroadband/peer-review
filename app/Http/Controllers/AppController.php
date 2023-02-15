<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class AppController extends Controller
{

    public function make(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'plan_id' => 'required|int',
            'customer_id' => 'required|int',
        ]);

        return Application::create([
            'address' => $request->address,
            'plan_id' => $request->plan_id,
            'customer_id' => $request->customer_id
        ]);
    }

    public function show($applicationId)
    {
        return Application::with('customer')->findOrFail($applicationId);
    }

}
