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
                <h2>Product List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-warning" href="/"> Back to Ecommerce</a>
                <a class="btn btn-success" href="/cart">Cart View</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    @if ($message = Session::get('error'))
        <div class="alert alert-error">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->pd_name }}</td>
            <td><img src="{{ asset('/images/'. $product->pd_img) }}"/></td>
            <td>{{ $product->pd_price }}</td>
            <td>
                <form action="/cart" method="POST">
                    @csrf
                    <input type="number" name="qty[{{ $i }}]">
                    <button type="submit" name="product[{{ $i }}]" value="{{$product->id}}" class="btn btn-success">Buy</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
        </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
</html>