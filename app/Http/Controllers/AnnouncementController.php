<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Support\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    protected ImageUploader $imageUploader;

    public function __construct(ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    public function adminIndex()
    {
        $announcements = Announcement::withTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('announcements.admin-listing', compact('announcements'));
    }

    public function adminCreate()
    {
        return view('announcements.admin-create');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'format'     => 'required|in:general,urgent,event_reminder,policy_update,congratulations',
            'priority'   => 'required|in:normal,important,urgent',
            'audience'   => 'required|array|min:1',
            'cover_photo'=> 'nullable|image|max:5120',
            'expires_at' => 'nullable|date|after:now',
            'publish_at' => 'nullable|date',
            'is_public'  => 'nullable|boolean',
            'is_pinned'  => 'nullable|boolean',
        ]);

        $audience = $request->input('audience', ['all']);
        if (in_array('all', $audience)) {
            Announcement::active()->get()->each(function ($a) {
                $a->archive(Auth::id(), 'Superseded by new announcement');
            });
        } else {
            foreach ($audience as $aud) {
                Announcement::active()
                    ->where(function ($q) use ($aud) {
                        $q->whereJsonContains('audience', 'all')
                          ->orWhereJsonContains('audience', $aud);
                    })
                    ->get()
                    ->each(fn($a) => $a->archive(Auth::id(), 'Superseded by new announcement'));
            }
        }

        $filename = null;
        if ($request->hasFile('cover_photo')) {
            try {
                $file = $request->file('cover_photo');
                $filename = $this->imageUploader->upload($file, 'announcements', 1400, 700);
            } catch (\Throwable $e) {
                \Log::error('Announcement cover upload failed', ['message' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Cover upload failed: ' . $e->getMessage(),
                ], 500);
            }
        }

        $announcement = Announcement::create([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'content'     => $request->content,
            'cover_photo' => $filename,
            'format'      => $request->format,
            'priority'    => $request->priority,
            'audience'    => $request->audience,
            'is_active'   => true,
            'is_pinned'   => $request->boolean('is_pinned'),
            'is_public'   => $request->boolean('is_public'),
            'publish_at'  => $request->publish_at,
            'expires_at'  => $request->expires_at,
            'created_by'  => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement published successfully.',
            'id'      => $announcement->id,
        ]);
    }

    public function adminEdit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.admin-edit', compact('announcement'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'format'   => 'required|in:general,urgent,event_reminder,policy_update,congratulations',
            'priority' => 'required|in:normal,important,urgent',
            'audience' => 'required|array|min:1',
        ]);

        if ($request->hasFile('cover_photo')) {
            if ($announcement->cover_photo) {
                Storage::disk('s3')->delete('announcements/' . $announcement->cover_photo);
            }
            $file = $request->file('cover_photo');
            $filename = $this->imageUploader->upload($file, 'announcements', 1400, 700);
            $announcement->cover_photo = $filename;
        }

        $announcement->update([
            'title'      => $request->title,
            'subtitle'   => $request->subtitle,
            'content'    => $request->content,
            'format'     => $request->format,
            'priority'   => $request->priority,
            'audience'   => $request->audience,
            'is_pinned'  => $request->boolean('is_pinned'),
            'is_public'  => $request->boolean('is_public'),
            'publish_at' => $request->publish_at,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json(['success' => true, 'message' => 'Announcement updated.']);
    }

    public function adminArchive(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->archive(Auth::id(), $request->input('reason', 'Manually archived by admin'));
        return response()->json(['success' => true, 'message' => 'Announcement archived.']);
    }

    public function memberIndex()
    {
        $user = Auth::user();
        $memberType = optional(optional($user)->memberInfo)->type;

        $announcements = Announcement::active()
            ->forAudience($memberType)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('announcements.member-listing', compact('announcements'));
    }

    public static function getLatestForDashboard($user = null)
    {
        $memberType = optional(optional($user)->memberInfo)->type;

        return Announcement::active()
            ->forAudience($memberType)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
