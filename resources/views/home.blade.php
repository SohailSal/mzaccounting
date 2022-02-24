@extends('base')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <div class="card">
                <div class="card-header">Invoices & Clients</div>

                <div class="card-body">
<a style="margin: 19px;" href="{{ route('invoices.index')}}" class="btn btn-primary">Invoices</a>
    <a style="margin: 19px;" href="{{ route('invoices.create')}}" class="btn btn-primary">New Invoice</a>
    <a style="margin: 19px;" href="{{action('InvoiceController@unpaid')}}" class="btn btn-primary">Unpaid Invoices</a>
<a style="margin: 19px;" href="{{ route('clients.index')}}" class="btn btn-primary">Clients</a>
    <a style="margin: 19px;" href="{{ route('clients.create')}}" class="btn btn-primary">New Client</a>

                </div>
            </div>


                <div class="card">
                <div class="card-header">Receipts & Payments</div>

                <div class="card-body">
<a style="margin: 19px;" href="{{ route('receipts.index')}}" class="btn btn-primary">Receipts</a>
    <a style="margin: 19px;" href="{{ route('receipts.create')}}" class="btn btn-primary">New Receipt</a>
    <!-- <a style="margin: 19px;" href="{{action('ReceiptController@getReceipts',  ['id'=>'25', 'actual'=> '26'])}}" class="btn btn-primary">Receipts PDF</a> -->
<a style="margin: 19px;" href="{{ route('posts.index')}}" class="btn btn-primary">Unposted Payments</a>
<a style="margin: 19px;" href="{{ route('payments.index')}}" class="btn btn-primary">Payments</a>
    <a style="margin: 19px;" href="{{ route('posts.create')}}" class="btn btn-primary">New Payment</a>
    <!-- <a style="margin: 19px;" href="{{action('PaymentController@getPaymentsn',  ['id'=>'25', 'actual'=> '26'])}}" class="btn btn-primary">Payments PDF</a> -->

                </div>
            </div>


                            <div class="card">
                <div class="card-header">Other Accounts & Transactions</div>

                <div class="card-body">
<a style="margin: 19px;" href="{{ route('accounts.index')}}" class="btn btn-primary">Accounts</a>
    <a style="margin: 19px;" href="{{ route('accounts.create')}}" class="btn btn-primary">New Head of Account</a>
<a style="margin: 19px;" href="{{ route('transactions.index')}}" class="btn btn-primary">Transactions</a>
    <a style="margin: 19px;" href="{{ route('transactions.create')}}" class="btn btn-primary">New Transaction</a>
<a style="margin: 19px;" href="{{ route('entries.index')}}" class="btn btn-primary">Other Reports</a>

                </div>
            </div>


        </div>
    </div>
</div>
@endsection
