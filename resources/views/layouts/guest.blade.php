<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-gray-50 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Form -->
            <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24">
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <div>
                        <a href="/" class="flex items-center gap-2 mb-8">
                            <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="3" width="18" height="18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="9" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <line x1="15" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <line x1="7" y1="12" x2="11" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <line x1="13" y1="12" x2="17" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span class="text-2xl font-bold text-gray-900">Apriori Sales</span>
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>

            <!-- Right Side - Image/Info -->
            <div class="hidden lg:block relative flex-1 bg-blue-600">
                <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
                    <h2 class="text-4xl font-bold mb-6">Discover Hidden Patterns in Your Sales Data</h2>
                    <p class="text-xl text-blue-100 mb-8">
                        Advanced market basket analysis powered by Apriori algorithm to help you make data-driven decisions.
                    </p>
                    
                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-200 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Easy Data Import</p>
                                <p class="text-blue-100 text-sm">Upload CSV or Excel files instantly</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-200 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Powerful Analytics</p>
                                <p class="text-blue-100 text-sm">Get actionable insights with support, confidence & lift metrics</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-200 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Secure & Private</p>
                                <p class="text-blue-100 text-sm">Your data stays yours with complete isolation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
