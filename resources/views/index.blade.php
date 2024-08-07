<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books Data</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS / Flowbite -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@2.0.1" integrity="sha384-QWGpdj554B4ETpJJC9z+ZHJcA/i59TyjxEPXiiUgN2WmTyV5OEZWCD6gQhgkdpB/" crossorigin="anonymous"></script>
</head>

<body>
    <main class="px-12 my-16">
        <div class="flex items-center justify-between p-4">
            <h1 class="font-bold text-2xl">Curated Books Data</h1>
            <div class="flex items-center">
                <div class="flex px-2 flex-col lg:flex-row items-center gap-4">
                    <input hx-get="/search" hx-target="#book-table" hx-trigger="keyup delay:500ms" id="search-input" type="text" name="q" class="p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search Name / Author" />
                </div>
                <a href="/create" class="flex items-center gap-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                    </svg>
                    Add New Book
                </a>
            </div>
        </div>

        <section>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-xl">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No/Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cover Image
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Author
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="book-table">
                        <x-book-table :data="$data" />
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        // Bind CSRF Token to HTMX Header
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('htmx:configRequest', (evt) => {
                evt.detail.headers['X-CSRF-Token'] = document.querySelector('meta[name="csrf-token"]').content;
            });
        });
    </script>
</body>

</html>
