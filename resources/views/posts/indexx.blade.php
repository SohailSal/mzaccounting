@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
    <h1 class="display-5">Delete Unposted Payments</h1>
    <div>
    <a style="margin: 5px;" href="{{ route('home')}}" class="btn btn-primary">Home</a>
    </div>
       <?php
            $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    ?>
    <div>
    {{$posts->links()}}
</div>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Ref</td>
          <td>Date of Payment</td>
          <td>Head of Account</td>
          <td>Payee</td>
          <td align='right'>Amount</td>
          <td style="text-align:center;">Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>{{$post->ref}}</td>
            <td>{{$post->date_of_payment}}</td>
            <td>{{$post->account->head_of_account}}</td>
            <td>{{$post->payee}}</td>
            <td align='right'>{{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($post->amount,'Rs.'))}}</td>
            <!-- <td>
                <a href="{{ route('posts.show',$post->id)}}">Show</a>
          	</td> -->
            <td>
                <form action="{{ route('posts.destroy', $post->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
<div>
    {{$posts->links()}}
</div>
@endsection
