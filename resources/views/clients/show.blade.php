@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Client's Detail</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('clients.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('clients.edit',$client->id)}}">Edit</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('clients.create')}}">Add new Client</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Name of Client:</strong>
            {{ $client->account->head_of_account }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Type of Client:</strong>
                {{$type->type_of_client}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Address:</strong>
            {{$client->address}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Phone:</strong>
            {{$client->phone}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{$client->email}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Contact Person:</strong>
            {{$client->person}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>NTN / STN:</strong>
            {{$client->tax}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Registration #:</strong>
            {{$client->registration}}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Date of Incorporation:</strong>
            {{$client->incorporation}}
        </div>
    </div>

</div>
@endsection

