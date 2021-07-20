<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$users = User::whereHas('roles', function($q){$q->where('name','!=' ,'Customer'); })->count();
		$customer = User::whereHas('roles', function($q){$q->where('name','Customer'); })->count();

        $monthly_customers = User::select('*')
            ->whereHas('roles', function($q){$q->where('name','Customer'); })
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('verified_by_vouch','success')
            ->count();

        $monthly_sign_up = User::select('*')
            ->whereHas('roles', function($q){$q->where('name','Customer'); })
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('verified_by_vouch','pending')
            ->count();
        

        return view('dashboards.index',compact('users', 'customer','monthly_customers','monthly_sign_up'));
    }
}
