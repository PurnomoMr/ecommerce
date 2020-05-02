<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product List</title>
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <style type="text/css">
            body{
                font-family: 'Lato', sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Summary Cart</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-warning" href="/"> Back to Ecommerce</a>
                <a class="btn btn-primary" href="/product-list">Add more product</a>
                <a class="btn btn-success" href="/promo-list">Add Promo</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    @if ($message = Session::get('success'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <div class="row">
        
        <div class="col-lg-6 margin-tb">
            <table class="table table-noborder">
            <tr>
                <th>Name</th>
                <td>{{ $cart->user_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $cart->user_email }}</td>
            </tr>
            <tr>
                <th>Promo Code</th>
                <td>{{ $cart->prm_code }}</td>
            </tr>
            </table>
        </div>
    </div>        
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Qty</th>
            <th>Product Total</th>
        </tr>
        @php
        $b = 0
        @endphp
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$b}}</td>
            <td>{{ $product->pd_name }}</td>
            <td style="text-align:right;">@currency($product->pd_price)</td>
            <td style="text-align:right;">{{ $product->cp_qty }}</td>
            <td style="text-align:right;">@currency($product->cp_total)</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="4" style="text-align:right;">Subtotal</th>
            <td style="text-align:right;">@currency($cart->cart_subtotal)</td>
        </tr>
        <tr>
            <th colspan="4" style="text-align:right;">Discount</th>
            <td style="text-align:right;">@currency($cart->cart_discount)</td>
        </tr>
        <tr>
            <th colspan="4" style="text-align:right;">Total Transaction</th>
            <td style="text-align:right;">@currency($cart->cart_total)</td>
        </tr>
    </table>
        </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
</html>