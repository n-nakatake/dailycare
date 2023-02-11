<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\History;
use App\Models\User;
use App\Models\Resident;
use Carbon\Carbon;

class TopController extends Controller
{
    public function index()
    {
        return view('admin.top.index');
    }
}