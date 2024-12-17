<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category-').$editCategory->name }}
        </h2>
    </x-slot>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('categories.edit', $editCategory->id) }}" id="edit-category-form" method="POST" class="space-y-6">
                    {{-- <form action="{{ route('categories.edit', $editCategory->name) }}" method="POST" class="space-y-6"> --}}
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Category Name
                                </label>
                                <input type="text" name="name" id="name" value="{{$editCategory->name}}" required placeholder="Enter category name"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">

                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Category Description
                                </label>
                                <textarea name="description" id="description" rows="4" placeholder="Enter category description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $editCategory->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn btn-primary">
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
                $(document).ready(function() {

                    $('#edit-category-form').validate({
                        rules: {
                            name: {
                                required: true,
                                minlength: 2,
                                maxlength: 50
                            },
                            description: {
                                maxlength: 255
                            }
                        },
                        messages: {
                            name: {
                                required: "Please enter the category name.",
                                minlength: "Category name must be at least 2 characters long.",
                                maxlength: "Category name cannot exceed 50 characters."
                            },
                            description: {
                                maxlength: "Category description cannot exceed 255 characters."
                            }
                        },
                        errorElement: "div",
                        errorPlacement: function(error, element) {
                            error.addClass("text-red-600 text-sm mt-1");
                            error.insertAfter(element);
                        },
                        highlight: function(element) {
                            $(element).addClass("border-red-500").removeClass("border-gray-300");
                        },
                        unhighlight: function(element) {
                            $(element).addClass("border-gray-300").removeClass("border-red-500");
                        }
                    });
                });
            </script>
        @endpush
    </x-guest-layout>
</x-app-layout>
