<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border px-4 py-2">Product</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item['name'] }}</td>
                    <td class="border px-4 py-2">{{ $item['quantity'] }}</td>
                    <td class="border px-4 py-2">${{ $item['price'] }}</td>
                    <td class="border px-4 py-2">${{ $item['quantity'] * $item['price'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <div class="container">

        <div class="d-flex justify-content-end gap-3">
            <div class="font-semibold text-xl">
                Total: ${{ number_format($totalPrice, 2) }}
            </div>
            <a href="{{ route('orders.showProducts') }}" class="btn btn-success">Add more items</a>
            <form action="{{ route('orders.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark">Proceed to Checkout</button>
            </form>
        </div>
    </div>


</x-app-layout>
