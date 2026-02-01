<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt',
            'format_type' => 'required|in:format_1,format_2'
        ]);

        $file = $request->file('file');

        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post('http://127.0.0.1:8001/parse', [
                    'format_type' => $request->format_type
                ]);

        if ($response->failed()) {
            return back()->with('error', 'Gagal proses data');
        }

        return response(
            $response->body(),
            200,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' =>
                    'attachment; filename=hasil.xlsx'
            ]
        );
    }
}
