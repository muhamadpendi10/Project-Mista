<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Data TXT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    @extends('layouts.admin')
    @section('title', 'Upload Data')
    @section('page-title', 'Upload Data TXT')

    @section('content')
    <div class="max-w-lg bg-white rounded-xl shadow p-6">

        <p class="text-sm text-slate-500 mb-6">
            Upload file data mentah (.txt) untuk diproses sistem
        </p>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/upload" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    File TXT
                </label>
                <input
                    type="file"
                    name="file"
                    accept=".txt"
                    required
                    class="block w-full text-sm text-slate-600
                        file:mr-4 file:rounded-md file:border-0
                        file:bg-slate-200 file:px-4 file:py-2
                        file:text-slate-700 hover:file:bg-slate-300"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-md bg-slate-900 py-2 text-white
                    hover:bg-slate-800 transition"
            >
                Upload File
            </button>
        </form>
    </div>
    @endsection

</html>
