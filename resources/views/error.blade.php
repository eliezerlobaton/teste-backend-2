<!DOCTYPE html>
<html>

<head>
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-4">
            <h1 class="text-2xl font-semibold">Error</h1>
            <p class="text-red-500 text-lg font-semibold">{{ $error }}</p>
            <p class="text-gray-600">{{ $message }}</p>
        </div>
    </div>
</body>

</html>
