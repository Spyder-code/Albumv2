@extends('layouts.admin')
@section('title','Tasks')
@section('level','Admin')
@section('profileImage',$image)
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if ($message = Session::get('success'))
        <div class="row">
            <div class="col mt-3">
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{{ $message }}</strong>
                </div>
            </div>
        </div>
    @endif
    @if ($message = Session::get('danger'))
        <div class="row">
            <div class="col mt-3">
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{{ $message }}</strong>
                </div>
            </div>
        </div>
    @endif
        </div>
    </div>
</div>

<div class="card-header text-center">
    <h3>Tanggal sekarang {{date("d, F Y ")}}</h3>
    <hr>
</div>
<div class="table-responsive text-center">
<table class="table table-bordered">
        <thead class="thead-light">
        <tr>
        <th scope="col">No</th>
        <th scope="col">Customer</th>
        <th scope="col">Pesan</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($task as $item)
            <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{$item->pesan}}</td>
            <td>
                @if ($item->status==1)
                    <i class="fas fa-check-circle" style="color:green"> Done </i>
                @else
                <i class="fas fa-hourglass-half" style="color:orange"> Processing... </i>
                @endif
            </td>
            <td>
                <form action="{{url('preview') }}" class="d-inline"  method="get">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id_customer }}">
                    <input type="hidden" name="name" value="{{ $item->name }}">
                    <button type="submit" class="btn btn-info">Lihat Album</button>
                </form>

                @if ($item->status==0)
                <form action="{{url('updateStatus') }}" class="d-inline"  method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary">Ubah status</button>
                </form>
                @endif

                <form action="{{url('download') }}" class="d-inline"  method="get">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id_customer }}">
                <input type="hidden" name="name" value="{{ $item->name }}">
                <button type="submit" class="btn btn-success">Download Album</button>
            </form>

            <form action="{{ url('hapus') }}" class="d-inline"  method="post">
                @method('delete')
                @csrf
                <input type="hidden" name="id" value="{{ $item->id_customer }}">
                <input type="hidden" name="nama" value="{{ $item->name }}">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus Album</button>
            </form>

            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>

@endsection
