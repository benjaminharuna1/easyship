<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;

class SupportController extends Controller
{
    public function index()
    {
        $messages = SupportMessage::orderBy('created_at', 'desc')->get();
        return view('admin.support-messages', compact('messages'));
    }
}
