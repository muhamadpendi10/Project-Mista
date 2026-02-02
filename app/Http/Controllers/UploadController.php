<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\WaUpload;
use Request;


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

        $response = Http::attach(
            'file',
            file_get_contents($request->file('file')->getRealPath()),
            $request->file('file')->getClientOriginalName()
        )->post('http://127.0.0.1:8001/parse', [
            'format_type' => $request->format_type
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Gagal parsing');
        }

        // SIMPAN EXCEL
        $filename = 'wa_' . time() . '.xlsx';
        $path = 'uploads/' . $filename;
        Storage::disk('public')->put($path, $response->body());

        // HITUNG ROW
        $sheet = IOFactory::load(
            storage_path('app/public/' . $path)
        )->getActiveSheet();

        $totalRows = max($sheet->getHighestDataRow() - 1, 0);

        // SIMPAN DATABASE
        WaUpload::create([
            'user_id' => Auth::id(),
            'filename' => $filename,
            'file_path' => $path,
            'total_rows' => $totalRows,
        ]);

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
