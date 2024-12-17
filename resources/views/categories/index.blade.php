<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="mb-4">

            <a href="{{ route('categories.add') }}" class="btn btn-primary">+ Add Category</a>
        </div>
        {{-- <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Products</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr id="row-{{ $category->id }}">
                        <td class="border px-4 py-2">{{ $category->name }}</td>
                        <td class="border px-4 py-2">{{ $category->description }}</td>
                        <td class="border px-4 py-2">{{ $category->products_count }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ route('categories.destroy', $category->id) }}" class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach

                    @include('categories.partials.table', ['categories' => $categories])


            </tbody>
        </table> --}}
        <div id="category-table">
            @include('categories.table', ['categories' => $categories])
        </div>
    </div>

    <x-guest-layout>
        @push('scripts')
            <script>

                $(document).on('click', '.delete-btn', function(e){
                    console.log("delete is working!");
                    e.preventDefault();
                    console.log('Delete button clicked for ID:', $(this).data('id'));

                    if(!confirm('Are you sure you want to delete this record?')){
                        return;
                    }

                    let id=$(this).data('id');
                    let url=`/categories/${id}/delete`;

                    $.ajax({
                        url:url,
                        type:'GET',
                        data:{
                            _token:'{{ csrf_token() }}',
                        },
                        success:function(response){
                            console.log('AJAX success:', response);
                            alert(response.success); //Display success message

                            console.log(`#row-${id}`);
                            $(`#row-${id}`).remove(); //remove Row from table
                            fetchUpdatedTable();
                        },
                        error:function(xhr){
                            alert('An error occured while trying to delete the record.');
                        }
                    });
                });
                $(document).on('click', '#pagination-links a', function (e) {
                    e.preventDefault();
                    let url = $(this).attr('href');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (response) {
                            $('#category-table').html(response.html); // Replace the table content
                        },
                        error: function () {
                            alert('An error occurred while trying to fetch the page.');
                        }
                    });
                });
                function fetchUpdatedTable() {
                    $.ajax({
                        url: '/categories',
                        type: 'GET',
                        success: function(response) {
                            // Replace the table content
                            $('#category-table').html(response.html); // Update table content
                        },
                        error: function(xhr) {
                            alert('An error occurred while trying to update the table.');
                        }
                    });
                }
            </script>
        @endpush
    </x-guest-layout>

</x-app-layout>
