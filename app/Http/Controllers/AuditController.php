<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $audits = Audit::with('user:id,name,email')
            ->select(['id','event','auditable_type','auditable_id','url','ip_address','user_agent','user_id','old_values','new_values','created_at'])
            ->latest()
            ->paginate(25);

        return view('audit.index', compact('audits'));
    }
}
