@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-12">
    <h1 class="display-5">Transaction's Details</h1>
        <div>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('transactions.index') }}"> Back</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('transactions.edit',$transaction->id)}}">Edit</a>
        <a style="margin: 19px;" class="btn btn-primary" href="{{ route('transactions.create')}}">New Transaction</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Ref:</strong>
            {{ $transaction->ref }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Date of transaction:</strong>
            {{ $transaction->date_of_transaction }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <strong>Description:</strong>
            {{ $transaction->description }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
        <table class="table table-striped">
            <thead>
                <tr>
                <th><strong>Head of Account</strong></th>
                <th><strong>Debit</strong></th>
                <th><strong>Credit</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->entries as $entry)
                <tr>
                    <td>{{$entry->account->head_of_account}}</td>
                    <td>{{$entry->debit}}</td>
                    <td>{{$entry->credit}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

</div>
@endsection

