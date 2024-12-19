<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="mb-4">
        <h3>Order Status: {{ ucfirst($order->status) }}</h3>
        <h4>Total Amount: ${{ $order->total_amount }}</h4>
    </div>

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
            @foreach($order->orderItems as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border px-4 py-2">{{ $item->quantity }}</td>
                    <td class="border px-4 py-2">${{ $item->price }}</td>
                    <td class="border px-4 py-2">${{ $item->quantity * $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <!-- Update order status -->
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="status" class="form-select" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-success mt-2">Update Status</button>
            <a href="{{ route('orders.index') }}">View Orders</a>
        </form>
    </div>
</x-app-layout>
