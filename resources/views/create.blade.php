@extends('template')

@section('content')

<div class="container-full">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Create a Pin</div>

                <div class="card-body">
                    <form action="{{ route('pin.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" />

                        <label for="description">Description:</label>
                      <textarea name="description" id="description" class="form-control" ></textarea>

                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image" class="form-control" />

                        <input type="submit" class="btn btn-primary" value="Submit Question" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection