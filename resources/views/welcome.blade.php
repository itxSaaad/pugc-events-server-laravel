<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PUGC Events API - Powered by Laravel Sanctum</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary: #324C80;
            --primary-light: rgba(50, 76, 128, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, #1a2a4f 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen gradient-bg">
        <div class="relative min-h-screen flex flex-col items-center justify-center px-4">
            <div class="relative w-full max-w-7xl">
                <header class="text-center py-16">
                    <h1 class="text-6xl font-bold text-white mb-6">PUGC Events API</h1>
                    <p class="text-xl text-gray-200 max-w-2xl mx-auto">
                        Secure REST API powered by Laravel Sanctum for PUGC Events Mobile Application
                    </p>
                </header>

                <main class="mt-12">
                    <div class="grid gap-6 lg:grid-cols-2 px-4">
                        <!-- API Features Cards -->
                        <div class="card-hover bg-white rounded-2xl p-8 backdrop-blur-lg bg-opacity-95">
                            <div class="flex flex-col">
                                <div class="p-3 rounded-lg bg-[#324C80] w-fit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800 mt-4">Sanctum Authentication</h2>
                                <p class="mt-3 text-gray-600">
                                    Secure token-based authentication using Laravel Sanctum for mobile app and API endpoints.
                                </p>
                            </div>
                        </div>

                        <div class="card-hover bg-white rounded-2xl p-8 backdrop-blur-lg bg-opacity-95">
                            <div class="flex flex-col">
                                <div class="p-3 rounded-lg bg-[#324C80] w-fit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800 mt-4">RESTful Endpoints</h2>
                                <p class="mt-3 text-gray-600">
                                    Well-documented API endpoints for events, users, and notifications with proper authentication.
                                </p>
                            </div>
                        </div>

                        <!-- Additional cards with similar structure -->
                        <!-- ... Add the remaining two cards with the same structure ... -->
                    </div>
                </main>

                <footer class="py-16 text-center">
                    <div class="inline-block px-8 py-4 bg-white rounded-2xl shadow-lg">
                        <p class="text-lg font-semibold text-[#324C80]">PUGC Events API v1.0</p>
                        <p class="mt-2 text-gray-600">Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
                        <p class="mt-1 text-gray-500">PHP v{{ PHP_VERSION }}</p>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>