@extends('base')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                <div class="card-header">Delete</div>
                <div class="card-body">
                    <a style="margin: 19px;" href="/erasePost" class="btn btn-primary">Unposted Payments</a>
                    <a style="margin: 19px;" href="/erasePayment" class="btn btn-primary">Payments</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
