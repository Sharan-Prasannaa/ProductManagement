<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <div class="container mx-auto py-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-4 flex items-center justify-between">
            <div class="flex-1 mr-4">
                <input
                type="text"
                id="search-input"
                placeholder="Search by Product name or description"
                class="border border-gray-300 rounded-md p-2 w-10"
            >
            </div>
            <div>
                <button id="toggle-filters" class="btn btn-secondary">Toggle Filters</button>
            </div>
        </div>

        <div class="mb-4 flex items-center justify-between">
            <div>
                <label class="inline-flex items-center">
                    <input
                        type="checkbox"
                        id="low-stock-filter"
                        name="low_stock"
                        value="1"
                        class="form-checkbox"
                    >
                    <span class="ml-2">  Show products with low stock (stock < 50)</span>
                </label>
            </div>
        </div>

        <!-- Filter Section -->
        <div id="filter-section" class="hidden mb-4 p-4 border border-gray-300 rounded-lg bg-gray-100">
            <form id="filter-form" class="space-y-4">
                <!-- Filter by Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 p-2 border-b border-gray-300 bg-gray-200 rounded-t-md">
                        Categories
                    </label>
                    <div class="mt-2 relative">
                        <div class="border border-gray-300 rounded-md shadow-sm p-3 bg-white">
                            <div class="dropdown">
                                @foreach ($categories as $category)
                                    <label class="inline-flex items-center">
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            class="form-checkbox"
                                        >
                                        <span class="ml-2">{{ $category->name }}</span>
                                    </label>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter by Supplier -->
                <div class="mt-4">
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 p-2 border-b border-gray-300 bg-gray-200 rounded-t-md">
                        Suppliers
                    </label>
                    <div class="mt-2 relative">
                        <div class="border border-gray-300 rounded-md shadow-sm p-3 bg-white">
                            <div class="dropdown">
                                @foreach ($suppliers as $supplier)
                                    <label class="inline-flex items-center">
                                        <input
                                            type="checkbox"
                                            name="suppliers[]"
                                            value="{{ $supplier->id }}"
                                            class="form-checkbox"
                                        >
                                        <span class="ml-2">{{ $supplier->name }}</span>
                                    </label>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Apply Filters
                    </button>
                </div>
            </form>

        </div>

        <!-- Selected Filters and Record Count -->
        <div id="filter-info" class="mb-4 hidden">
            <p class="text-lg font-semibold">Selected Filters:</p>
            <ul id="selected-filters" class="list-disc ml-4"></ul>
            <p id="record-count" class="mt-2 text-gray-700"></p>
        </div>


        <div id="product-table">
            @include('products.table', ['products' => $products])
        </div>
    </div>

<x-guest-layout>
    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#search-input').on('keyup', function () {
                const searchQuery = $(this).val(); // Get the search input value

                $.ajax({
                    url: "{{ route('products') }}",
                    type: 'GET',
                    data: {
                        search: searchQuery
                    },
                    success: function (response) {
                        // Update the product table with the search results
                        $('#product-table').html(response.html);
                    },
                    error: function () {
                        alert('An error occurred while searching.');
                    }
                });
            });
        });

        $(document).ready(function () {
            // Handle low stock checkbox change
            $('#low-stock-filter').on('change', function () {
                const lowStock = $(this).is(':checked') ? 1 : 0;

                // Make AJAX request
                $.ajax({
                    url: "{{ route('products') }}",
                    type: 'GET',
                    data: { low_stock: lowStock },
                    success: function (response) {
                        $('#product-table').html(response.html);
                    },
                    error: function () {
                        alert('An error occurred while filtering low stock products.');
                    }
                });
            });
        });



        $(document).ready(function () {

            $('#toggle-filters').on('click', function () {
                console.log('Filter toggle button clicked!');
                $('#filter-section').toggleClass('hidden');
            });

            // Handle filter form submission
            $('#filter-form').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('products') }}",
                    type: 'GET',
                    data: formData,
                    success: function (response) {
                        $('#product-table').html(response.html); // Update the table content
                        updateFilterInfo(); // Update selected filters and record count
                    },
                    error: function () {
                        alert('An error occurred while applying the filters.');
                    }
                });
            });

            // Update selected filters and record count
            function updateFilterInfo() {
                let selectedCategories = [];
                let selectedSuppliers = [];

                $('input[name="categories[]"]:checked').each(function () {
                    selectedCategories.push($(this).next('span').text());
                });

                $('input[name="suppliers[]"]:checked').each(function () {
                    selectedSuppliers.push($(this).next('span').text());
                });

                let selectedFilters = [];
                if (selectedCategories.length > 0) {
                    selectedFilters.push('Categories: ' + selectedCategories.join(', '));
                }
                if (selectedSuppliers.length > 0) {
                    selectedFilters.push('Suppliers: ' + selectedSuppliers.join(', '));
                }

                if (selectedFilters.length > 0) {
                    $('#selected-filters').html('');
                    selectedFilters.forEach(filter => {
                        $('#selected-filters').append(`<li>${filter}</li>`);
                    });
                    $('#filter-info').removeClass('hidden');
                } else {
                    $('#filter-info').addClass('hidden');
                }

                // Update record count
                const recordCount = $('#product-table table tbody tr').filter(function () {
                    return $(this).find('td').length > 1; // Exclude "No products found" rows
                }).length;
                $('#record-count').text(`Total records: ${recordCount}`);
            }
        });
    </script>
    @endpush
</x-guest-layout>
</x-app-layout>
