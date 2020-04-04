@extends('layouts.admin')
@section('title','Admin')
@section('level','Admin')
@section('profileImage',$image)
@section('content')
    <div class="container">
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
        <div class="row">
            <div class="col text-center">
                @foreach ($user as $item)
                <img src="{{ asset('assets/images/'.$item->image) }}" class="mt-3 mb-3 img-thumbnail">
                </div>
                    <div class="col mt-3">
                        <h4>Foto Profil</h4>
                        <hr>
                    <form  method="post" action="{{url('changeImageAdmin')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="img" class="file" name="images"/>
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                        <input type="hidden" name="nama" value="{{ $item->nama }}">
                        <input type="hidden" name="img" value="{{ $item->image }}">
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <button type="submit" class="btn btn-success float-right mr-5">Change</button>
                    </form>
                    <h4 class="mt-5">Ganti Password</h4>
                    <hr>
                    <form class="form-row"  method="post" action="{{url('changePasswordAdmin')}}">
                        @csrf
                        <div class="col">
                            <div class="form-group">
                                <label for="pass1">Old Password</label>
                                <input type="password" class="form-control" name="pass1">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pass2">New Password</label>
                                <input type="password" class="form-control" name="pass2">
                            </div>
                            <button type="submit" class="btn btn-success mb-2 float-right mr-5">Change</button>
                        </div>
                    </form>
                    @endforeach
            </div>
        </div>
    </div>
@endsection
