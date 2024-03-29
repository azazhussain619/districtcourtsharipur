<x-admin-layout>
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> {{ session('success') }}
        </div>
@endif

<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Designation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Designation</li>
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
                    <form method="POST" action="{{ route('designations.update', $designation->id) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf

                        <x-forms.input name="name" :value="$designation->name"/>
                        <div class="form-group">
                            <x-forms.label name="category"/>
                            <select name="category" id="category" class="form-control">
                                <option value="staff" {{ ($designation->category == 'staff') ? "selected" : "" }}>Staff</option>
                                <option value="judges" {{ ($designation->category == 'judges') ? "selected" : "" }}>Judges</option>
                            </select>
                            @error('category')
                            <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-forms.button>Update</x-forms.button>

                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="email">Email address:</label>--}}
                        {{--                            <input type="email" class="form-control" placeholder="Enter email" id="email">--}}
                        {{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-admin-layout>
