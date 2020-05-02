<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image PDF</title>
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
        <div class="container" style="margin-top: 50px;">
            <h2 class="text-left">Ecommerce</h2><br>
            <a href="{{ route('product.index') }}" class="btn btn-success btn-sm">Manage Product</a>
            <a href="{{ route('promo.index') }}" class="btn btn-primary btn-sm">Manage Promo</a>
            <a href="/user" class="btn btn-primary btn-sm">Add to Cart</a>
            <br><br>
            <table class="table table-bordered table-striped">
            </table>

        </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
</html>