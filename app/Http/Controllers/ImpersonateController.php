<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImpersonateController extends Controller
{
    /**
     * Start impersonating a member.
     * Only Admins (role_id=1) can do this.
     */
    public function take(Request $request, int $id)
    {
        $admin = Auth::user();

        // Security: only Admin can impersonate
        if ($admin->role_id !== 1) {
            abort(403, 'Unauthorized.');
        }

        $target = User::findOrFail($id);

        // Security: cannot impersonate admins
        if (!$target->canBeImpersonated()) {
            return back()->with('error', 'This user cannot be impersonated. Only Members can be viewed this way.');
        }

        // Log to Laravel log and to audit trail
        Log::info('Impersonation started', [
            'admin_id'    => $admin->id,
            'admin_email' => $admin->email,
            'target_id'   => $target->id,
            'target_email'=> $target->email,
            'ip'          => $request->ip(),
        ]);

        $admin->impersonate($target);

        return redirect('/')->with('success', 'You are now viewing as ' . $target->name);
    }

    /**
     * Stop impersonating and return to admin account.
     */
    public function leave(Request $request)
    {
        $impersonated = Auth::user();
        $manager = app('impersonate');
        $adminId = $manager->getImpersonatorId();

        Auth::user()->leaveImpersonation();

        $admin = User::find($adminId);

        Log::info('Impersonation ended', [
            'admin_id'         => $adminId,
            'was_impersonating'=> $impersonated->id,
            'ip'               => $request->ip(),
        ]);

        return redirect('/')->with('success', 'You have returned to your admin account.');
    }
}
