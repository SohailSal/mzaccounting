<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{config('app.name')}}</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"  type="text/css" />

<style>
.row div {
  padding: 5px;
}
</style>

</head>
<body>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Entries
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('invoices.create')}}">New Invoice</a>
                            <a class="dropdown-item" href="{{ route('receipts.create')}}">New Receipt</a>
                            <a class="dropdown-item" href="{{ route('posts.create')}}">New Payment</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('transactions.create')}}">Enter Journal Voucher</a>
                            <a class="dropdown-item" href="{{ route('clients.create')}}">Enter new Client</a>
                            <a class="dropdown-item" href="{{ route('accounts.create')}}">Enter new Account</a>
                        </div>
                        </div>

                        <div class="btn-group" style="margin-left: 4px;">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            View
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('invoices.index')}}">Invoices</a>
                            <a class="dropdown-item" href="{{ route('receipts.index')}}">Receipts</a>
                            <a class="dropdown-item" href="{{ route('posts.index')}}">Unposted Payments</a>
                            <a class="dropdown-item" href="{{ route('payments.index')}}">Payments</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('transactions.index')}}">Journal Entries</a>
                            <a class="dropdown-item" href="{{ route('clients.index')}}">Clients</a>
                            <a class="dropdown-item" href="{{ route('accounts.index')}}">Accounts</a>
                        </div>
                        </div>

                        <div class="btn-group" style="margin-left: 4px;">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reports
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{action('InvoiceController@unpaid')}}">Unpaid invoices</a>
                            <a class="dropdown-item" href="{{action('EntryController@clientBal')}}">Debtors balances</a>
                            <!-- <a class="dropdown-item" href="{{action('ReceiptController@getReceipts',  ['id'=>'25', 'actual'=> '26'])}}">Receipts detail</a> -->
                            <!-- <a class="dropdown-item" href="{{action('PaymentController@getPayments',  ['id'=>'25', 'actual'=> '26'])}}">Payments detail</a> -->
                            <a class="dropdown-item" href="{{ route('entries.index')}}">Other reports</a>
                        </div>
                        </div>
                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



  <div class="container">
    @yield('main')
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@yield('script')

</body>
</html>
