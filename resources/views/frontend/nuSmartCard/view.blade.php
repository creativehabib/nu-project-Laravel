<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50 h-screen">
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-6">Your Submitted Data</h1>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 max-w-2xl mx-auto">
        <table class="w-full text-left">
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Name:</th>
                <td class="p-2">{{ $data->name }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Department:</th>
                <td class="p-2">{{ $data->department }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Designation:</th>
                <td class="p-2">{{ $data->designation }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">PF Number:</th>
                <td class="p-2">{{ $data->pf_number }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">ID Card Number:</th>
                <td class="p-2">{{ $data->id_card_number }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Birth Date:</th>
                <td class="p-2">{{ $data->birth_date }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">PRL Date:</th>
                <td class="p-2">{{ $data->formatted_prl_date }} ({{ $data->relative_prl_date }})</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Mobile:</th>
                <td class="p-2">{{ $data->mobile_number }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Blood Group:</th>
                <td class="p-2">{{ $data->blood?->name }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Present Address:</th>
                <td class="p-2">{{ $data->present_address }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Emergency Contact:</th>
                <td class="p-2">{{ $data->emergency_contact }}</td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Signature:</th>
                <td class="p-2">
                    <img src="{{ asset('uploads/signature/' . $data->signature) }}" alt="Signature" class="w-40 h-12 border rounded-md">
                </td>
            </tr>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-2 w-50">Image:</th>
                <td class="p-2">
                    <img src="{{ asset('uploads/images/' . $data->image) }}" alt="Signature" class="w-full h-full border rounded-md">
                </td>
            </tr>
        </table>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('nu-smart-card.store_data') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Back to Form
            </a>
        </div>
    </div>
</div>
</body>
</html>
