
<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2> --}}
        <p class="px-2">{{ __("You're logged in!") }}</p>
    </x-slot>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card-container justify-center" style="gap: 4rem;">
                        <a href="{{ route('products') }}" style="text-decoration: none">
                            <div class="card">
                                <div class="card-title">Total Products</div>
                                <div class="card-content">{{ $totalProducts }}</div>
                            </div>
                        </a>
                        <a href="{{ route('categories') }}" style="text-decoration: none">
                            <div class="card">
                                <div class="card-title">Total Categories</div>
                                <div class="card-content">{{ $totalCategories }}</div>
                            </div>
                        </a>
                        <a href="{{ route('suppliers') }}" style="text-decoration: none">
                            <div class="card">
                                <div class="card-title">Total Suppliers</div>
                                <div class="card-content">{{ $totalSuppliers }}</div>
                            </div>
                        </a>
                        <div class="card">
                            <div class="card-title">Total Orders</div>
                            <div class="card-content">{{ $totalOrders }}</div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-6 py-10">

                        <div class="card2">
                            <div class="card-title">Revenue Last 30 Days</div>
                            <div class="card-content">{{ $revenueLast30Days }}</div>
                        </div>

                        <div class="card2">
                            <div class="card-title">Top 5 Product Sold</div>
                            <div class="card-content">{{ $top5Products->first()->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
