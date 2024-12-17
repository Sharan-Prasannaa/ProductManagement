<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Supplier') }}
        </h2>
    </x-slot>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('suppliers.add') }}" id="add-supplier-form" method="POST" class="bg-white shadow-md rounded-lg p-8 space-y-6">
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder="Enter supplier name"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter supplier email"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Enter phone number"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea
                                    name="address"
                                    id="address"
                                    rows="1"
                                    placeholder="Enter supplier address"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="btn btn-primary py-8"
                            >
                                Create Supplier
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
                    $('#add-supplier-form').validate({
                        rules: {
                            name: {
                                required: true,
                                maxlength: 255
                            },
                            email: {
                                required: true,
                                email: true,
                                remote: {
                                    url: "{{ route('suppliers.check-email') }}", // check email uniqueness via an AJAX request
                                    type: "POST",
                                    data: {
                                        email: function () {
                                            return $('#email').val();
                                        },
                                        _token: "{{ csrf_token() }}"
                                    }
                                }
                            },
                            phone: {
                                required: false,
                                regex: /^[0-9]{10}$/
                            },
                            address: {
                                required: true
                            }
                        },
                        messages: {
                            name: {
                                required: "Please enter the supplier name.",
                                maxlength: "The name cannot exceed 255 characters."
                            },
                            email: {
                                required: "Please enter an email address.",
                                email: "Please enter a valid email address.",
                                remote: "This email is already in use."
                            },
                            phone: {
                                regex: "Please enter a valid 10-digit phone number."
                            },
                            address: {
                                required: "Please enter an address."
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

                    // Custom validator for regex
                    jQuery.validator.addMethod("regex", function (value, element, param) {
                        return this.optional(element) || param.test(value);
                    }, "Invalid format.");
                });
            </script>
        @endpush

    </x-guest-layout>
</x-app-layout>
