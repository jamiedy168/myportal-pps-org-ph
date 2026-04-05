<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function adminCertificateUpload()
    {
        return view('maintenance.certificate-upload');
    }

    public function adminListMember()
    {
        return view('maintenance.certificate-admin-list');
    }

    public function uploadListMember(Request $request)
    {
        return response()->json(['success' => true]);
    }

    public function adminSearch()
    {
        return view('maintenance.certificate-admin-list');
    }

    public function adminRemoveMember()
    {
        return response()->json(['success' => true]);
    }

    public function adminDownloadCertificate2($prc_number)
    {
        return response()->json(['success' => true]);
    }
}
