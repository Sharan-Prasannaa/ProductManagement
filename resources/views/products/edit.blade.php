<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product Details - ').$editProduct->name }}
        </h2>
    </x-slot>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.update',$editProduct->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-8 space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-6">

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ $editProduct->name }}"
                                    required
                                    placeholder="Enter product name"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="2"
                                    placeholder="Enter product description"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >{{ old('description', $editProduct->description) }}</textarea>
                                @error('description')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Product Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    value="{{ $editProduct->price }}"
                                    required
                                    step="0.01"
                                    placeholder="Enter product price"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('price')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                <input
                                    type="number"
                                    name="stock"
                                    id="stock"
                                    value="{{ $editProduct->stock }}"
                                    required
                                    placeholder="Enter stock quantity"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('stock')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category - {{ $editProduct->category->name }}</label>
                                <select
                                    name="category_id"
                                    id="category_id"
                                    required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier - {{ $editProduct->supplier->name }}</label>
                                <select
                                    name="supplier_id"
                                    id="supplier_id"
                                    required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="" disabled selected>Select a supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="btn btn-primary py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-guest-layout>
        @push('scripts')
            <script>
                $(document).ready(function () {

                    $('#add-product-form').validate({
                        rules: {
                            name: {
                                required: true,
                                minlength: 2,
                                maxlength: 255
                            },
                            description: {
                                maxlength: 255
                            },
                            price: {
                                required: true,
                                number: true,
                                min: 0.01
                            },
                            stock: {
                                required: true,
                                digits: true,
                            },
                            category_id: {
                                required: true
                            },
                            supplier_id: {
                                required: true
                            }
                        },
                        messages: {
                            name: {
                                required: "Please enter the product name.",
                                minlength: "Product name must be at least 3 characters long.",
                                maxlength: "Product name cannot exceed 255 characters."
                            },
                            description: {
                                maxlength: "Description cannot exceed 500 characters."
                            },
                            price: {
                                required: "Please enter the product price.",
                                number: "Please enter a valid number.",
                                min: "Price must be greater than 0."
                            },
                            stock: {
                                required: "Please enter the stock quantity.",
                                digits: "Stock quantity must be a whole number.",
                            },
                            category_id: {
                                required: "Please select a category."
                            },
                            supplier_id: {
                                required: "Please select a supplier."
                            }
                        },
                        errorElement: "div",
                        errorPlacement: function (error, element) {
                            error.addClass("text-red-600 text-sm mt-1");
                            error.insertAfter(element);
                        },
                        highlight: function (element) {
                            $(element).addClass("border-red-500").removeClass("border-gray-300");
                        },
                        unhighlight: function (element) {
                            $(element).addClass("border-gray-300").removeClass("border-red-500");
                        }
                    });
                });
            </script>
        @endpush
    </x-guest-layout>
</x-app-layout>
