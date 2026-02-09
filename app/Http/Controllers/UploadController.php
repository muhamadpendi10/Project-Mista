<?php

namespace App\Http\Controllers;

use App\Models\WaUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadController extends Controller
{
    // ===============================
    // FORM UPLOAD
    // ===============================
    public function index()
    {
        $user = auth()->user();

        $layout = $user->role === 'admin'
            ? 'layouts.admin'
            : 'layouts.app';

        return view('upload.index', compact('layout'));
    }

    // ===============================
    // PROSES UPLOAD
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'file'        => 'required|file|mimes:txt',
            'format_type' => 'required|in:format_1,format_2',
        ]);

        // kirim ke FastAPI
        $response = Http::timeout(60)
            ->attach(
                'file',
                file_get_contents($request->file('file')->getRealPath()),
                $request->file('file')->getClientOriginalName()
            )
            ->post('http://127.0.0.1:8001/parse', [
                'format_type' => $request->format_type,
            ]);

        if ($response->failed()) {
            abort(500, 'FastAPI error: ' . $response->body());
        }

        // simpan file hasil
        $filename = 'wa_' . time() . '.xlsx';
        $path = 'uploads/' . $filename;

        Storage::disk('public')->put($path, $response->body());

        // hitung total row
        $spreadsheet = IOFactory::load(
            storage_path('app/public/' . $path)
        );

        $sheet = $spreadsheet->getActiveSheet();
        $totalRows = max($sheet->getHighestDataRow() - 1, 0);

        // simpan ke database
        WaUpload::create([
            'user_id'    => Auth::id(),
            'filename'   => $filename,
            'file_path'  => $path,
            'total_rows' => $totalRows,
        ]);

        // langsung download
        return response(
            $response->body(),
            200,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' =>
                    'attachment; filename=hasil.xlsx',
            ]
        );
    }

    // ===============================
    // HISTORY UPLOAD
    // ===============================
    public function history(Request $request)
    {
    $user = auth()->user();

    // Base query
    $query = $user->role === 'admin'
        ? WaUpload::with('user')
        : WaUpload::where('user_id', $user->id);

    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL CEPAT
    |--------------------------------------------------------------------------
    */

    if ($request->filter === 'today') {
        $query->whereDate('created_at', now()->toDateString());
    }

    if ($request->filter === 'yesterday') {
        $query->whereDate('created_at', now()->subDay()->toDateString());
    }

    if ($request->filter === '7days') {
        $query->where('created_at', '>=', now()->subDays(7));
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOM DATE RANGE
    |--------------------------------------------------------------------------
    */

    if ($request->start_date && $request->end_date) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH FILE NAME
    |--------------------------------------------------------------------------
    */

    if ($request->search) {
        $query->where('filename', 'like', '%' . $request->search . '%');
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION (Lebih Profesional)
    |--------------------------------------------------------------------------
    */

    $uploads = $query->latest()->paginate(10)->withQueryString();

    $layout = $user->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.app';

    return view('upload.history', compact('uploads', 'layout'));
    }

    // ===============================
    // DOWNLOAD ULANG
    // ===============================
    public function download(WaUpload $upload)
    {
    $user = auth()->user();

    if ($user->role !== 'admin' && $upload->user_id !== $user->id) {
        abort(403);
    }

    if (!$upload->file_path) {
        abort(404, 'File path kosong');
    }

    if (!Storage::disk('public')->exists($upload->file_path)) {
        abort(404, 'File tidak ditemukan');
    }

    return Storage::disk('public')->download(
        $upload->file_path,
        'hasil_' . $upload->filename
    );
    }

}
