<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaypalSettings;
use Illuminate\Support\Facades\Auth;

class PaypalSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role != 'Employee'){
            $paypalSettings = PaypalSettings::getAllPaypalSettings();
            return view('paypal_settings.list', compact('paypalSettings'));
        }
        else{
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'endpoint' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
        ]);

        PaypalSettings::where('mode', $request->mode)->update([
            'endpoint' => $request->endpoint,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'mode' => $request->mode,
            'status' => $request->status,
        ]);

        return redirect()->route('paypal_settings.index')->with('success', 'Paypal settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
