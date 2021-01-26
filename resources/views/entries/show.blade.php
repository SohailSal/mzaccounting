@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Entry</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('entries.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('entries.edit',$entry->id)}}">Edit</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('entries.create')}}">New Entry</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Head of Account:</strong>
            {{ $entry->account->head_of_account }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Transaction ID:</strong>
            {{ $entry->transaction_id }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Debit:</strong>
            {{ $entry->debit }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Credit:</strong>
            {{ $entry->credit }}
        </div>
    </div>

</div>
@endsection

