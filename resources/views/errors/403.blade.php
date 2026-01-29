<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Akses Ditolak
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-center">
                    <!-- Icon -->
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                        <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        Akses Ditolak
                    </h3>

                    <!-- Message -->
                    <p class="text-gray-600 mb-6">
                        Anda tidak memiliki izin untuk mengakses halaman ini.
                    </p>

                    <!-- Role Info -->
                    @auth
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 inline-block">
                        <p class="text-sm text-gray-500">
                            Anda masuk sebagai: 
                            <span class="font-semibold text-gray-700">
                                {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Staff' }}
                            </span>
                        </p>
                    </div>
                    @endauth

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        <button onclick="history.back()" 
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </button>
                    </div>

                    <!-- Help Text -->
                    <p class="text-sm text-gray-400 mt-8">
                        Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
