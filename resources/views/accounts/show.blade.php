@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Heads of Account</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('accounts.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('accounts.edit',$account->id)}}">Edit</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('accounts.create')}}">New Head of Account</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>ID:</strong>
            {{ $account->id }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Head of Account:</strong>
            {{ $account->head_of_account }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Type of Account:</strong>
            {{ $account->type->type_of_account }}
        </div>
    </div>

</div>
@endsection

