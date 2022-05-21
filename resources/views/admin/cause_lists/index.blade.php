<x-admin-layout>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Cause Lists</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Cause Lists</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered data-table text-center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Court ID</th>
                            <th>Date</th>
                            <th>Normal Cause List</th>
                            <th>Old Cause List</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('cause_lists.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'court_id', name: 'court_id'},
                    {data: 'date', name: 'date'},
                    {data: 'normal_file', name: 'normal_file'},
                    {data: 'old_file', name: 'old_file'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>

</x-admin-layout>



