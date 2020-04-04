    @extends('layouts.user')
    @section('title','Uploads')
    @section('container')

    <div>
    <div class="container-fluid sticky-top bg-light">
        <div class="row">
            {{-- @foreach ($layouts as $item)
            <div class="col">
                <form action="{{url('layouts')}}" method="get" class="dropdown-item">
                @csrf
                    <input type="hidden" name="id_user" value="{{$id}}">
                    <input type="hidden" name="id_layouts" value="{{$item->id}}">
                    <p class="text-center">{{$item->nama}}</p>
                    <img src="{{asset('assets/images/layouts/'.$item->image)}}" onclick="submit()" width="100%" height="70px">
                </form>
                <hr>
            </div>
            @endforeach --}}
            <button type="button" class="btn btn-primary mt-2 ml-5" data-toggle="modal" data-target="#exampleModal">
                Layouts
            </button>
            <div class="col">
                <div class="col mt-2 mr-5">
                    <a href="{{url('logout')}}" type="submit" class="btn btn-success float-right ml-2 d-inline">Save and Logout</a>
                </div>
            </div>
        </div>
    </div>

        <div class="container mt-5">
            <div class="print-layouts">
                @section('bg',asset('assets/images/'.$nama.'/'.$image))
                @foreach ($userLayouts as $item)
            <div hidden>{{$hasil = session()->get('angka')}} </div>
                @include('templates/'.$item->id_layout)
                @endforeach
            </div>
        </div>
    </div>
        @endsection



        @section('sidebar')

    {{-- upload file --}}
    <div class="container sticky-top">
        <div class="card">
            <div class="card-header bg-info">
                    <div class="text-center">
                        <h6>Background</h6>
                    </div>
            </div>
            <div class="card-body">
                <form  method="post" action="{{url('bgUpload')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="img" name="images"/>
                    <span class="text-danger">{{ $errors->first('images') }}</span>
                    <input type="hidden" name="nama" value="{{ $nama }}">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                </form>
                @if ($image!="default.jpg")
                <div class="card mt-3" style="height:100px">
                    <img src="{{asset('assets/images/'.$nama.'/'.$image)}}" id="picture">
                </div>
                @endif
                <hr>
            </div>
        </div>
            <div class="card mt-5">
                <div class="card-header text-center bg-warning">
                    <h4>{{ $total }} Item</h4>
                </div>
                <div class="card-body"  id="scroll" style="overflow:scroll; height:200px">
                    <form  method="post"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="nama" value="{{ $nama }}">
                        <input type="file" id="image" name="image[]" multiple />
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                        <br>
                        <button type="submit" class="btn btn-success mt-2">Submit</button>
                    </form>
                    <div class="row">
                    @foreach ($album as $item)
                        <div class="col col-3">
                            <div class="card mt-3">
                                <form action="{{url('hapus/'.$item->id)}}" method="get">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="nama" value="{{ $nama }}">
                                    <input type="hidden" name="order" value="{{ $item->order }}">
                                <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </form>
                                <img src="{{asset('assets/images/'.$item->name.'/'.$item->image)}}" width="151" height="100" id="picture">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

    </div>

    @endsection

        <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:100%">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Layout</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($layouts as $item)
            <div class="col col-4">
                <form action="{{url('layouts')}}" method="get" class="dropdown-item">
                @csrf
                    <input type="hidden" name="id_user" value="{{$id}}">
                    <input type="hidden" name="id_layouts" value="{{$item->id}}">
                    <p class="text-center">{{$item->nama}}</p>
                    <img src="{{asset('assets/images/layouts/'.$item->image)}}" onclick="submit()" width="100%" height="70px">
                </form>
                <hr>
            </div>
            @endforeach
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
