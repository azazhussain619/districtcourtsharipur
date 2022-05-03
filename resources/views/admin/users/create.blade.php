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
                    <h1 class="m-0">Add New User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add New User</li>
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
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf

                        <x-forms.input name="name"/>
                        <x-forms.input type="email" name="email"/>
                        <x-forms.input type="password" name="password"/>
                        <div class="form-group">
                            <x-forms.label name="designation"/>
                            <select name="designation" id="designation" class="form-control">
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                @endforeach
                            </select>
                            @error('designation')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-forms.input type="file" name="image"/>

                        <x-forms.button>Submit</x-forms.button>

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
