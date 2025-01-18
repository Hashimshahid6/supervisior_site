<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\WebsiteSettings;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $packages = Packages::getAllPackages();
        $perPage = request()->input('per_page', 10);
        $payments = Payments::getAllPayments()->paginate($perPage);
        return view('payments.list', compact('payments', 'packages'));
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
        $setting = WebsiteSettings::getAllWebsiteSettings()->where('id', 1)->first();
        $invoice = Payments::with(['package', 'user'])->where('id', $id)->first();
        return view('payments.details', compact('invoice', 'setting'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
