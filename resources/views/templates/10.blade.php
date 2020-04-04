<div class="page-break"></div>
@if ($a==1)
<form action="{{url('layouts/'.$item->id)}}" method="get">
    @csrf
    <input type="hidden" name="id_user" value="{{$item->id_user}}">
    <input type="hidden" name="id" value="{{$item->id}}">
    <button type="submit" class="close ml-2" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</form>
@endif
<div class="container mt-5 mb-5">
    <div class="card" style="background-image:url(@yield('bg'));border-color:black;background-size:cover; height:500px" id="layout">
        <div class="row mt-5 ml-5 mr-5">
            <div class="col mb-3">
                <div id="c" class="card" style="height:200px; border-color:black" >
                    @if ($loop->iteration==1)
                    <div hidden>{{$hasil = 1}}</div>
                            @foreach ($album as $item)
                            @if ($item->order==1)
                            <img src="{{asset('assets/images/'.$item->name.'/'.$item->image)}}" class="image-thumbnail"  id="{{ $item->id }}" data-drop="{{ $item->order }}" data-drag="{{ $item->order }}">
                            @endif
                            @endforeach
                    @else
                        <div hidden>
                        {{ $hasil=$hasil+1}}
                            </div>
                            @foreach ($album as $item)
                            @if ($item->order==$hasil)
                            <img src="{{asset('assets/images/'.$item->name.'/'.$item->image)}}" class="image-thumbnail"  id="{{ $item->id }}" data-drop="{{ $item->order }}" data-drag="{{ $item->order }}">
                            @endif
                            @endforeach
                    @endif
                </div>
            </div>
            <div class="col">
                <div id="c" class="card" style="height:200px; border-color:black" >
                    <div hidden>
                        {{ $hasil=$hasil+1}}
                            </div>
                    @foreach ($album as $item)
                            @if ($item->order==$hasil)
                            <img src="{{asset('assets/images/'.$item->name.'/'.$item->image)}}" class="image-thumbnail"  id="{{ $item->id }}" data-drop="{{ $item->order }}" data-drag="{{ $item->order }}">
                            @endif
                            @endforeach
                </div>
            </div>
            <div class="col">
                <div id="c" class="card" style="height:200px; border-color:black" >
                    <div hidden>
                        {{ $hasil=$hasil+1}}
                            </div>
                    @foreach ($album as $item)
                            @if ($item->order==$hasil)
                            <img src="{{asset('assets/images/'.$item->name.'/'.$item->image)}}" class="image-thumbnail"  id="{{ $item->id }}" data-drop="{{ $item->order }}" data-drag="{{ $item->order }}">
                            @endif
                            @endforeach
                </div>
            </div>
        </div>

        <div class="row ml-5 mr-5">
            <div class="col mb-3">
                <div id="c" class="card" style="height:150px; border-color:black" >
                    <div hidden>
                        {{ $hasil=$hasil+1}}
                            </div>
                    @foreach ($album as $item)
                            @if ($item->order==$hasil)
                            <img src="{{asset('assets/images/'.$item->name.'/'.$item->image)}}" class="image-thumbnail"  id="{{ $item->id }}" data-drop="{{ $item->order }}" data-drag="{{ $item->order }}">
                            @endif
                            @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="rounded-circle float-right bg-light mr-3" style="width:50px;height:50px;font-size:22pt"><h6 class="ml-2 mt-1" style="font-size:22pt">{{ $loop->iteration }}</h6></div>
            </div>
        </div>
    </div>
</div>
<div class="page-break"></div>

