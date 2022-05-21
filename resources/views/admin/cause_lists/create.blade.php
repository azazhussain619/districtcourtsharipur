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
                    <h1 class="m-0">Add New Cause List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add New Cause List</li>
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
                    <form method="POST" action="{{ route('cause_lists.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <x-forms.label name="court"/>
                            <select name="court" id="court" class="form-control">
                                @foreach($courts as $court)
                                    <option value="{{ $court->id }}">{{ $court->name }}</option>
                                @endforeach
                            </select>
                            @error('court')
                            <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-forms.input type="date" name="date"/>

                        <x-forms.input type="file" name="normal_file"/>
                        <x-forms.input type="file" name="old_file"/>

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
