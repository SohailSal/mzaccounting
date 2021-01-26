@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Type of Account</h1> 
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('types.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('types.edit',$type->id)}}">Edit</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('types.create')}}">New Type</a>
        </div>
    </div>
</div>
   
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>ID:</strong>
            {{ $type->id }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Type of Account:</strong>
            {{ $type->type_of_account }}
        </div>
    </div>
</div>
@endsection

