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
        <h1 class="display-5">Update an Entry</h1>
        <form method="post" action="{{ route('entries.update', $entry->id) }}">
            @method('PATCH')
            @csrf

            <div class="form-group">
              <label for="account_id">Head of Account:</label>
              <select class="form-control" name="account_id">
                  @foreach (App\Account::all() as $item)
                    <option value="{{$item->id}}" {{$item->id == $entry->account_id ? 'selected':''}}> {{$item->head_of_account}} </option>
                  @endforeach
              </select>
            </div>

            <div class="form-group">
                <label for="transaction_id">Transaction ID:</label>
                <input type="text" class="form-control" name="transaction_id" value="{{ $entry->transaction_id }}" />
            </div>

            <div class="form-group">
                <label for="debit">Debit:</label>
                <input type="text" class="form-control" name="debit" value="{{ $entry->debit }}" />
            </div>

            <div class="form-group">
                <label for="credit">Credit:</label>
                <input type="text" class="form-control" name="credit" value="{{ $entry->credit }}" />
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
