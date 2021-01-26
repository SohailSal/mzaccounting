@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Type of Client</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('clienttypes.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('clienttypes.edit',$clienttype->id)}}">Edit</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('clienttypes.create')}}">New Type</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>ID:</strong>
            {{ $clienttype->id }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Type of Client:</strong>
            {{ $clienttype->type_of_client }}
        </div>
    </div>
</div>
@endsection

