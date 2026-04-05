<?php

namespace App\Http\Controllers;

use App\Models\IvsStream;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class IvsStreamController extends Controller
{
    /**
     * ADMIN — List all IVS streams.
     */
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }
        $streams = IvsStream::orderBy('created_at', 'desc')->get();
        return view('maintenance.ivs.index', compact('streams'));
    }

    /**
     * ADMIN — Show create form.
     */
    public function create()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }
        return view('maintenance.ivs.form', [
            'stream'      => null,
            'memberTypes' => $this->memberTypeOptions(),
        ]);
    }

    /**
     * ADMIN — Store new IVS stream.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'button_label' => 'required|string|max:100',
            'ivs_url'      => 'required|string',
            'starts_at'    => 'nullable|date',
            'ends_at'      => 'nullable|date|after_or_equal:starts_at',
        ]);

        $stream = new IvsStream();
        $stream->name              = $request->name;
        $stream->button_label      = $request->button_label;
        $stream->ivs_url           = $request->ivs_url;
        $stream->status            = $request->has('status');
        $stream->starts_at         = $request->starts_at
            ? Carbon::parse($request->starts_at, 'Asia/Manila')->utc()
            : null;
        $stream->ends_at           = $request->ends_at
            ? Carbon::parse($request->ends_at, 'Asia/Manila')->utc()
            : null;
        $stream->allowed_types     = $request->input('allowed_types', []);
        $stream->allow_vip         = $request->has('allow_vip');
        $stream->allow_all_members = $request->has('allow_all_members');
        $stream->allow_admin       = $request->has('allow_admin');
        $stream->created_by        = auth()->user()->name;
        $stream->updated_by        = auth()->user()->name;
        $stream->save();

        return redirect()->route('admin.ivs.index')
            ->with('success', 'IVS stream created successfully.');
    }

    /**
     * ADMIN — Show edit form.
     */
    public function edit(IvsStream $ivsStream)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }
        return view('maintenance.ivs.form', [
            'stream'      => $ivsStream,
            'memberTypes' => $this->memberTypeOptions(),
        ]);
    }

    /**
     * ADMIN — Update existing IVS stream.
     */
    public function update(Request $request, IvsStream $ivsStream)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }

        $request->validate([
            'name'         => 'required|string|max:255',
            'button_label' => 'required|string|max:100',
            'ivs_url'      => 'required|string',
            'starts_at'    => 'nullable|date',
            'ends_at'      => 'nullable|date|after_or_equal:starts_at',
        ]);

        $ivsStream->name              = $request->name;
        $ivsStream->button_label      = $request->button_label;
        $ivsStream->ivs_url           = $request->ivs_url;
        $ivsStream->status            = $request->has('status');
        $ivsStream->starts_at         = $request->starts_at
            ? Carbon::parse($request->starts_at, 'Asia/Manila')->utc()
            : null;
        $ivsStream->ends_at           = $request->ends_at
            ? Carbon::parse($request->ends_at, 'Asia/Manila')->utc()
            : null;
        $ivsStream->allowed_types     = $request->input('allowed_types', []);
        $ivsStream->allow_vip         = $request->has('allow_vip');
        $ivsStream->allow_all_members = $request->has('allow_all_members');
        $ivsStream->allow_admin       = $request->has('allow_admin');
        $ivsStream->updated_by        = auth()->user()->name;
        $ivsStream->save();

        return redirect()->route('admin.ivs.index')
            ->with('success', 'IVS stream updated successfully.');
    }

    /**
     * ADMIN — Delete an IVS stream.
     */
    public function destroy(IvsStream $ivsStream)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }
        $ivsStream->delete();
        return redirect()->route('admin.ivs.index')
            ->with('success', 'IVS stream deleted.');
    }

    /**
     * ADMIN — Toggle status on/off via AJAX.
     */
    public function toggleStatus(Request $request, IvsStream $ivsStream)
    {
        if (auth()->user()->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $ivsStream->status     = !$ivsStream->status;
        $ivsStream->updated_by = auth()->user()->name;
        $ivsStream->save();

        return response()->json([
            'success' => true,
            'status'  => $ivsStream->status,
        ]);
    }

    /**
     * MEMBER — Generate signed URL from sidebar Watch Now link.
     * Access check: role, member_type, vip handled by IvsStream::canUserWatch().
     */
    public function generateToken(Request $request, IvsStream $ivsStream)
    {
        $user = auth()->user();

        if (!$ivsStream->isLive()) {
            abort(403, 'This stream is not currently live.');
        }

        if (!$ivsStream->canUserWatch($user)) {
            abort(403, 'You do not have access to this stream.');
        }

        $signedUrl = URL::temporarySignedRoute(
            'ivs.player',
            now()->addHours(12),
            ['ivsStream' => $ivsStream->id]
        );

        Log::info('IVS stream access granted', [
            'user_id'     => $user->id,
            'email'       => $user->email,
            'stream_id'   => $ivsStream->id,
            'stream_name' => $ivsStream->name,
            'ip'          => $request->ip(),
        ]);

        return redirect($signedUrl);
    }

    /**
     * Member type options for admin form checkboxes.
     */
    private function memberTypeOptions(): array
    {
        return [
            2  => 'DIPLOMATE',
            3  => 'FELLOW',
            4  => 'EMERITUS FELLOW',
            5  => 'ALLIED HEALTH PROFESSIONALS',
            6  => 'RESIDENT/TRAINEES',
            7  => 'GOVERNMENT PHYSICIAN',
            9  => 'FELLOWS-IN-TRAINING',
            10 => 'ACTIVE MEMBER',
        ];
    }

    /**
     * Show the IVS player for a signed stream link.
     */
    public function player(Request $request, IvsStream $ivsStream)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'This link has expired or is invalid. Please return to the portal and click the stream link again.');
        }

        if (!$ivsStream->isLive()) {
            abort(403, 'This stream has ended or is not currently active.');
        }

        $playbackUrl = $ivsStream->ivs_url;
        $streamName  = $ivsStream->name;
        $buttonLabel = $ivsStream->button_label;

        return view('ivs.player', compact('playbackUrl', 'streamName', 'buttonLabel'));
    }

    /**
     * MEMBER — Generate signed URL from an event page.
     * Access: anyone who can view the event page (no payment check).
     * The stream must be live and linked to the event.
     */
    public function generateEventToken(Request $request, Event $event)
    {
        $user = auth()->user();

        // Load the linked IVS stream
        $ivsStream = $event->ivsStream;

        if (!$ivsStream) {
            abort(404, 'No IVS stream is linked to this event.');
        }

        if (!$ivsStream->isLive()) {
            abort(403, 'The livestream for this event is not currently active.');
        }

        // Generate 12-hour signed URL — stateless, zero DB on player page
        // Safe for 9000 concurrent viewers
        $signedUrl = URL::temporarySignedRoute(
            'ivs.player',
            now()->addHours(12),
            ['ivsStream' => $ivsStream->id]
        );

        Log::info('IVS event stream access granted', [
            'user_id'     => $user->id,
            'email'       => $user->email,
            'event_id'    => $event->id,
            'stream_id'   => $ivsStream->id,
            'stream_name' => $ivsStream->name,
            'ip'          => $request->ip(),
        ]);

        return redirect($signedUrl);
    }

    /**
     * ADMIN — Save IVS stream link to an event via AJAX.
     * Called from the event edit page dropdown.
     */
    public function linkToEvent(Request $request)
    {
        if (auth()->user()->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'event_id'      => 'required|integer',
            'ivs_stream_id' => 'nullable|integer|exists:ivs_streams,id',
        ]);

        $event = Event::findOrFail($request->event_id);
        $event->ivs_stream_id = $request->ivs_stream_id ?: null;
        $event->updated_by    = auth()->user()->name;
        $event->save();

        $streamName = null;
        if ($event->ivs_stream_id) {
            $stream = IvsStream::find($event->ivs_stream_id);
            $streamName = $stream ? $stream->name : null;
        }

        return response()->json([
            'success'     => true,
            'stream_name' => $streamName,
        ]);
    }
}
