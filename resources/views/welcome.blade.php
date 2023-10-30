<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <a href="\">
        <h1 class="text-2xl font-semibold mb-4">Lista de Filmes</h1>
        </a>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($paginatedItems as $item)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="{{ $item['primaryImage']['url'] }}" alt="{{ $item['titleText']['text'] }}"
                        class="w-full h-40 object-cover mb-2">
                    <h2 class="text-xl font-semibold">{{ $item['titleText']['text'] }}</h2>
                    <p class="text-gray-600 text-sm">{{ $item['releaseYear']['year'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex justify-between">
            <div class="flex items-center">
                Página: {{ $current_page }}
                &nbsp;
                Total Filmes: {{ $total }}
                &nbsp;
                Total Páginas: {{ $last_page }}
            </div>
            <div>
                @if ($current_page > 1)
                    <a href="{{ $prev_page_url }}" class="text-blue-500 hover:underline">Página anterior</a>
                @endif
                @if ($current_page < $last_page)
                    <a href="{{ $next_page_url }}" class="text-blue-500 hover:underline ml-4">Próxima página</a>
                @endif
            </div>
        </div>


    </div>
</body>

</html>
