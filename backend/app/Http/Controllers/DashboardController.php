<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\User;
use App\Models\Payments;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // echo session()->get('token'); die;
        $sales = Payments::where('payment_status', 'Completed')->sum('amount');
        $projects = Projects::where('status', 'Active')->get();
        $companies = User::where('role', 'Company')->where('status', 'Active')->get();
        $employees = User::where('role', 'Employee')->where('status', 'Active')->get();
        
        $activePackage = null;

        $user = auth()->user();
        if ($user->role == 'Company') {
            $employees = User::where('company_id', $user->id)->where('role', 'Employee')->where('status', 'Active')->get();
            $projects = Projects::where('user_id', $user->id)->where('status', 'Active')->get();
            $activePackage = $user->package()->where('status', 'Active')->first();
        }//

        // Get subscription data for the graph
        $subscriptions = Payments::selectRaw('MONTH(payments.created_at) as month, packages.name as package_name, 
        COUNT(payments.id) as count, SUM(payments.amount) as total_sales')
            ->join('packages', 'payments.package_id', '=', 'packages.id')
            ->where('payments.payment_status', 'Completed')
            ->whereYear('payments.created_at', Carbon::now()->year)
            ->groupBy('month', 'packages.name')
            ->get();

        return view('index', compact('projects', 'companies', 'employees', 'sales', 'subscriptions', 'activePackage'));
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
