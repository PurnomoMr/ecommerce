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
                <h2>Promo List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-warning" href="/"> Back to Ecommerce</a>
                <a class="btn btn-success" href="{{ route('promo.create') }}"> Create New Promo</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Promo Code</th>
            <th>Promo Percentage</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($promos as $promo)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $promo->prm_code }}</td>
            <td>{{ $promo->prm_percentage }}</td>
            <td>
                <form action="{{ route('promo.destroy',$promo->id) }}" method="POST">

    
                    <a class="btn btn-primary" href="{{ route('promo.edit',$promo->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
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