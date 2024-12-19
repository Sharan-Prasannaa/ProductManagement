<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Total Products</h3>
                    <p class="mt-2 text-xl font-bold text-gray-600">{{ $totalProducts }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Total Categories</h3>
                    <p class="mt-2 text-xl font-bold text-gray-600">{{ $totalCategories }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Total Suppliers</h3>
                    <p class="mt-2 text-xl font-bold text-gray-600">{{ $totalSuppliers }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Top 5 Products</h3>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        @foreach ($top5Products as $product)
                            <li class="flex justify-between">
                                <span class="font-semibold">{{ $product['name'] }}</span>
                                <span>{{ $product['total_sold'] }} sold</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Revenue Last 30 Days</h3>
                    <p class="mt-2 text-xl font-bold text-gray-600">{{ $revenueLast30Days }}</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
