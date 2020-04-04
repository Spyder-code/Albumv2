@extends('layouts.superUser')
@section('title','Customer')
@section('level','Super User')
@section('profileImage',$image)
@section('content')
<div class="card-header text-center">
    <h3>Tanggal sekarang {{date("d, F Y ")}}</h3>
    <h6>Jumlah data {{$total}}</h6>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col">
                <form class="form-inline my-2 my-lg-0" method="get" action="{{ url('superUser/cari/customer') }}">
                    @csrf
                    <input class="form-control mr-sm-2" type="search" placeholder="Cari Berdasarkan nama admin" name="cari" style="width:330px;">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive text-center">
<table class="table table-bordered">
        <thead class="thead-light">
        <tr>
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Phone</th>
        <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($user as $item)
            <tr>
                @if ($item->name=="aziz")
                    @continue
                @endif
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->phone }}</td>
            <td>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#example{{ $item->id }}">
                    Ubah
                </button>

                    <!-- Modal -->
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
                                <form method="post" action="{{ url('ubahCustomer') }}">
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
                    </div>

                <form action="{{ url('hapusCustomer') }}" class="d-inline"  method="post">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                </form>

                <a target="d-blank" href="https://wa.me/{{$item->phone}}?text=Login+pada+https://album.spydercode.site+dengan+%3A%0D%0Ausername+%3A+{{ $item->name }}%0D%0Apassword+%3A+{{ session('passCustomer') }}" class="btn btn-success d-inline">WhatsApp</a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <hr>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        <i class="fas fa-plus-circle"></i>
        Tambah Customer
    </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        <label for="nama">Nama</label>
                        @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror">
                        <label for="password">Password</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        <label for="phone">Phone</label>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
                </div>
            </div>
            </div>
        </div>
@endsection
