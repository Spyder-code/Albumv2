<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

    <title>@yield('title')</title>
</head>

<body>
        <div class="container-fluid mt-5">
            <div class="print-layouts">
                @foreach ($user as $item)
                @section('bg',asset('assets/images/'.$item->name.'/'.$item->image))
                @endforeach
                @foreach ($userLayouts as $item)
            <div hidden>{{$hasil = session()->get('angka')}} </div>
                @include('templates/'.$item->id_layout)
                @endforeach
            </div>
        </div>

        <div class="container-fluid fixed-bottom mt-5">
            <div class="row">
                <div class="col">
                        <button onclick="window.print()" style="width:100%" class="btn btn-secondary">Print</button>
                        <a href="{{ url('admin/task') }}" style="width:100%" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script type="text/javascript" src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- MDB core JavaScript -->
</body>
</html>











