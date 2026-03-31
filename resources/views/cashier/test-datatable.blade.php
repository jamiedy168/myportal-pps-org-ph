<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-event" activeSubitem="">
    </x-auth.navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <style>
            .dataTables_wrapper .dataTables_paginate .paginate_button {
   border-radius: 50% !important;
   padding: 0.5em 0.9em !important;
}
        </style>
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Cashier"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
           
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table id="datatable" class="table" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <td>Name</td>
                                        <td>Description</td>
                                        <td>Amount</td>
                                        <td></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                      </div>
                </div>
            </div>
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/cashier-event.css" rel="stylesheet" />

    
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products.getProducts') }}",
                    type: "POST",
                    data: function (data) {
                        data.search = $('input[type="search"]').val();
                    }
                },
                order: ['1', 'DESC'],
                pageLength: 10,
                searching: true,
                aoColumns: [
                    {
                        data: 'first_name',
                    },
                    {
                        data: 'middle_name',
                    },
                    {
                        data: 'last_name',
                    },
                    {
                        data: 'id',
                        width: "20%",
                        render: function(data, type, row) {
                            return `<a href="{{route('view')}}">View</a>`; //you can add your view route here
                        }
                    }
                ]
            });
        });

        
    </script>

    @endpush
</x-page-template>
