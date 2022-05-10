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
    <h1 class="display-5">Add a Client</h1>
  <div>
      <form method="post" action="{{ route('clients.store') }}" class="prevent-multi">
          @csrf
          <div class="form-group">
              <label for="name_of_client">Name of Client:</label>
              <input type="text" class="form-control" name="name_of_client"/>
          </div>

          <div class="form-group">
              <label for="clienttype_id">Type of Client:</label>
              <select class="form-control" name="clienttype_id">
                  @foreach (App\ClientType::all() as $item)
                  <option value="{{$item->id}}">{{$item->type_of_client}}</option>
                  @endforeach
              </select>
          </div>

          <div class="form-group">
              <label for="address">Address:</label>
              <textarea rows="3" class="form-control  rounded-0" name="address" id="address" ></textarea>

          </div>

          <div class="form-group">
              <label for="phone">Phone:</label>
              <input type="text" class="form-control" name="phone"/>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" name="email"/>
          </div>

          <div class="form-group">
              <label for="person">Contact Person:</label>
              <input type="text" class="form-control" name="person"/>
          </div>

          <div class="form-group">
              <label for="tax">NTN / STN:</label>
              <input type="text" class="form-control" name="tax"/>
          </div>

          <div class="form-group">
              <label for="registration">Registration #:</label>
              <input type="text" class="form-control" name="registration"/>
          </div>

          <div class="form-group">
              <label for="incorporation">Date of Incorporation:</label>
              <input type="text" class="form-control" name="incorporation"/>
          </div>

          <button type="submit" class="btn btn-primary prevent-multi-submit">Add Client</button>
      </form>
  </div>
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

    $('.prevent-multi').on('submit', function(){
        $('.prevent-multi-submit').attr('disabled','true');
        return true;
    });

});


</script>

@endsection
