@extends('layouts.dashboard.app')
@section('title')
    Create User
@endsection
@section('body')
    <center>
        <div class="card-body shadow mb-4 col-10 ">
            <h2> Show User</h2><br>
            <img src="{{ asset($user->image) }}" class="img-thumbnail" height="300" width="200"><br><br>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value="Name : {{ $user->name }}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value="User Name : {{ $user->username }}" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value="Email : {{ $user->email }}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value="Status: {{ $user->status == 1 ? 'Active' : 'Not Active' }}" type="text"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value=" Verified : {{ $user->email_verified_at == 1 ? 'Active' : 'Not Active' }}"
                            type="text" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value="Phone : {{ $user->phone }}" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input disabled value=" Street : {{ $user->street }}" type="text" class="form-control">

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input disabled value=" Country: {{ $user->country }}" type="text" class="form-control">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input disabled value=" City : {{ $user->city }}" type="text" class="form-control">

                </div>
            </div>
            {{-- <div class="col-6">
                <input disabled value="{{ $user->street }}" type="text" class="form-control">

            </div> --}}



            <br><br>
            <a href="{{ route('admin.users.changeStatus', $user->id) }}"
                class="btn btn-primary">{{ $user->status == 1 ? 'Block' : 'Active' }}</a>
            <a href="javascript:void(0)"
                onclick="if(confirm('Are You Sure To Delete User?')){document.getElementById('delete_user_{{ $user->id }}').submit()}return false "
                class="btn btn-primary">DELETE</a>
            <form id="delete_user_{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}"
                method="POST">
                @csrf
                @method('DELETE')

            </form>
        </div>
        </div>
        </div>
    </center>
@endsection
