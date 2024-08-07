<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books Data</title>
    <!-- Tailwind CSS / Flowbite -->
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    <main class="px-12 my-16">
        <section class="py-8 md:py-16 antialiased">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
                    <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                        @if($data->image_path)
                        <img class="w-full" src="{{ asset('uploads/' . $data->image_path) }}" alt="{{ $data->name }}" />
                        @endif
                    </div>

                    <div class="mt-6 sm:mt-8 lg:mt-0">
                        <h1
                            class="text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $data->name }}
                        </h1>

                        <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{$data->status}}
                            </span>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                Author: <b>{{$data->author}}</b>
                            </span>
                        </div>

                        <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                        <div class="mb-6 text-gray-500 dark:text-gray-400 whitespace-pre-line">
                            {{ $data->description }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
