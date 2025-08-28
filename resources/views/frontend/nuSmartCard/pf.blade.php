<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Find ID Card</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50 h-screen">
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-6">Find ID Card</h1>
    <form action="{{ route('nu-smart-card.pf-show') }}" method="POST" class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        @csrf
        <label class="block mb-2 text-sm font-medium">PF Number</label>
        <input type="text" name="pf_number" class="w-full p-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-gray-700" placeholder="Enter PF Number">
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Submit</button>
    </form>
</div>
</body>
</html>
