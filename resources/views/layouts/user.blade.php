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
    <link href="{{asset('assets/css/upload.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-ui.js')}}"></script>

    <title>@yield('title')</title>
</head>

<body class="bg-light">
    <script>
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $( function() {
            console.log("ok");
            $("#scroll").scroll(function(){
                console.log("scroll");

            });

                $( "img" ).draggable({
                    revert: "invalid",
                    cursor: "crosshair",
                    start:function(event,ui){

                        $(this).css({
                            "width":"150px",
                            "height":"150px",
                            "position":"absolute",
                            "z-index" : "9999"
                            })
                        $(this).draggable("option","cursorAt",{
                            left:Math.floor(this.clientWidth / 2),
                            top:Math.floor(this.clientHeight / 2)
                        });
                    },
                    stop:function(event,ui){
                        $(this).css({"width":"100%","height":"100%"})
                    }
                });
                $("img").droppable({
                drop: function(event, ui) {
                    var drop = $(this).attr("data-drop");
                    var src = $(this).attr('src');
                    var drag = ui.draggable[0].dataset.drag;
                    var idDrag = ui.draggable[0].id;
                    var img1 = ui.draggable[0].src;
                    var img2 = ui.draggable[0];
                    var idDrop = $(this).attr("id");
                    var url = "{{ url('change') }}";
                    $(this).attr('src',img1);
                    $(img2).attr('src',src);
                    $("img").animate({
                        top: "0px",
                        left: "0px"
                    })
                        $.ajax({
                        url: url,
                        method: 'POST',
                        data: {drop:drop, drag:drag, idDrop:idDrop, idDrag:idDrag},
                        success: function(data) {
                        console.log('success');
                        $(".loader").show();
                        location.reload();
                            // $(".loader").hide();
                        }
                    });
                }
            });
        } );
        </script>
    <div class="containerLoader">
        <div class="loader" style="display:none; background:url({{asset('assets/images/color-loading.gif')}}) 50% 50% no-repeat;"></div>
    </div>
    <div class="jumbotron text-center mt" style="background-image:url({{ asset('assets/images/background/background.jpg') }})">
        <h1 class="border" style="background-color:white; border-radius:18px; width:30%; margin-left:35%; border-color:yellow">Album Foto Editor</h1>
    </div>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col col-8">
                <div class="card" style="height:100%">
                    @yield('container')
                </div>
            </div>
            <div class="col col-4">
                @yield('sidebar')
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->


<!-- Bootstrap tooltips -->
<script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- MDB core JavaScript -->
</body>
</html>
