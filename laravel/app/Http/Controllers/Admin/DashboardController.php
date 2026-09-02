<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addtracking;
use App\Models\SupportMessage;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalShipments = Addtracking::count();
        $pendingShipments = Addtracking::where('status', 'Pending')->count();
        $inTransit = Addtracking::where('status', 'In Transit')->count();
        $delivered = Addtracking::where('status', 'Delivered')->count();
        $supportMessages = SupportMessage::orderBy('created_at', 'desc')->take(5)->get();
        $recentShipments = Addtracking::orderBy('created_at', 'desc')->take(8)->get();

        return view('admin.dashboard', compact(
            'totalShipments',
            'pendingShipments',
            'inTransit',
            'delivered',
            'supportMessages',
            'recentShipments'
        ));
    }
}
