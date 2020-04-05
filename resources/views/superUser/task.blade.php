@extends('layouts.superUser')
@section('title','Tasks')
@section('level','Super User')
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
        <th scope="col">Admin</th>
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
            <td>{{ $item->admin }}</td>
            <td>{{ $item->customer }}</td>
            <td>{{$item->pesan}}</td>
            <td>
                @if ($item->status==1)
                    <i class="fas fa-check-circle" style="color:green"> Done </i>
                @else
                <i class="fas fa-hourglass-half" style="color:orange"> Processing... </i>
                @endif
            </td>
            <td>
                {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#example{{ $item->id }}">Ubah</button> --}}

                    {{-- <!-- Modal -->
                    <div class="modal fade" id="example{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ url('ubahAdmin') }}">
                                    @method('put')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" value="{{$item->name}}" class="form-control">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{$item->phone}}" class="form-control">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                            </div>
                        </div>
                        </div>
                    </div> --}}

                <form action="{{ url('hapusTask') }}" class="d-inline"  method="post">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                </form>

                {{-- <a href="https://wa.me/{{$item->hp}}?text=" class="btn btn-success d-inline">WhatsApp</a> --}}
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <hr>

    <!-- Button trigger modal -->

<div class="container mt-5 mb-5">
    <div class="row">
        @foreach ($admin as $item)
        <div class="col col-3">
            <div class="card">
                <div class="card-header bg-info">
                    <img src="{{ asset('assets/images/'.$item->image) }}" class="img-thumbnail" alt="">
                </div>
                <div class="card-body text-center">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total tasks: <h1 class="bg-warning">{{ $item->hit }}
                            </h1></li>
                        <li class="list-group-item">{{ $item->name }}</li>
                      </ul>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#example{{ $item->id }}" style="width:100%">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Task
                    </button>
                     <!-- Modal -->
    <div class="modal fade" id="example{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    @csrf
                    <input type="hidden" name="hit" value="{{ $item->hit }}">
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <label for="admin">Admin</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="admin">
                        <option value="{{$item->id}}">{{ $item->name }}</option>
                    </select>
                    <label for="customer">Customer</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="customer">
                        @foreach ($user as $item)
                        @if ($item->name=="aziz")
                            @continue
                        @endif
                        <option value="{{$item->id}}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('pesan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <label for="pesan">Pesan</label>
                    <textarea class="form-control @error('nama') is-invalid @enderror"" id="exampleFormControlTextarea1" name="pesan" rows="3"></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
            </div>
        </div>
        </div>
    </div>
                </div>
        </div>
    </div>
    @endforeach
</div>
</div>


@endsection
