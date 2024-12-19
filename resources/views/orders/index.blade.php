<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders Management') }}
        </h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <!-- Filter by status -->
        <form action="{{ route('orders.filterByStatus') }}" method="GET">
            <select name="status" onchange="this.form.submit()" class="form-select">
                <option value="">Filter by Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
        <form action="{{ route('orders.filterByStatus') }}" method="GET" class="ml-4">
            <button type="submit" class="btn btn-secondary">Clear Filter</button>
        </form>
    </div>
    <div id="order-table">
        @include('orders.table', ['orders' => $orders])
    </div>
    </div>

</x-app-layout>
