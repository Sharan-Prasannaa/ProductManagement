<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suppliers') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="mb-4">

            <a href="{{ route('suppliers.create') }}" class="btn btn-warning">+ Create Supplier</a>
        </div>
        <div id="supplier-table">
            @include('suppliers.table', ['suppliers' => $suppliers])
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
                    let url=`/suppliers/${id}/delete`;

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
                            $('#supplier-table').html(response.html); // Replace the table content
                        },
                        error: function () {
                            alert('An error occurred while trying to fetch the page.');
                        }
                    });
                });
                function fetchUpdatedTable() {


                    $.ajax({
                        url: '/suppliers',
                        type: 'GET',
                        success: function(response) {
                            // Replace the table content
                            $('#supplier-table').html(response.html); // Update table content
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
