@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-5">Update a Type</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <form method="post" action="{{ route('clienttypes.update', $clienttype->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="type_of_client">Type of Client:</label>
                <input type="text" class="form-control" name="type_of_client" value="{{ $clienttype->type_of_client }}" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
