<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Products To Order') }}
        </h2>
    </x-slot>
    @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Price: ${{ number_format($product->price, 2) }}
                            </p>
                            <form action="{{ route('orders.addToCart', $product->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-dark"
                                >
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
