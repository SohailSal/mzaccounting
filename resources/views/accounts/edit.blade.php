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
        <h1 class="display-5">Update a Head of Account</h1>
        <form method="post" action="{{ route('accounts.update', $account->id) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="head_of_account">Head of Account:</label>
                <input type="text" class="form-control" name="head_of_account" value="{{ $account->head_of_account }}" />
            </div>

            <div class="form-group">
              <label for="type_id">Type of Account:</label>
              <select class="form-control" name="type_id">
                  @foreach (App\Type::all() as $item)
                    <option value="{{$item->id}}" {{$item->id == $account->type_id ? 'selected':''}}> {{$item->type_of_account}} </option>
                  @endforeach
              </select>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {

    $(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
    if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });

});


</script>

@endsection
