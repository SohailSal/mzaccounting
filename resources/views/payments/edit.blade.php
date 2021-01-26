@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h1 class="display-5">Update a Transaction</h1>
        <form method="post" action="{{ route('transactions.update', $transaction->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="ref">Reference:</label>
                <input type="text" class="form-control" name="ref" value="{{ $transaction->ref }}" />
            </div>

            <div class="form-group">
                <label for="date_of_transaction">Date of transaction:</label>
                <input type="text" class="form-control" name="date_of_transaction" value="{{ $transaction->date_of_transaction }}" />
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" value="{{ $transaction->description }}" />
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
