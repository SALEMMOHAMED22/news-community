@extends('layouts.dashboard.app')
@section('title')
    Create User
@endsection
@section('body')
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
       <center>
        <div class="card-body shadow mb-4 col-10 ">
            <h2>Create New User</h2><br>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Enter User Name" class="form-control">
                        @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Enter User UserName" class="form-control">
                        @error('userName')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Enter User Email" class="form-control">
                        @error('email')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Enter User Phone" class="form-control">
                        @error('phone')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option selected disabled>select status</option>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                        @error('status')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <select name="email_verified_at" class="form-control">
                            <option selected disabled>select Email Status</option>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                        @error('email_verified_at')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="file" name="image"  class="form-control">
                        @error('image')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="country" placeholder="Enter Country Name" class="form-control">
                        @error('country')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="city" placeholder="Enter City Name" class="form-control">
                        @error('city')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="street" placeholder="Enter Street Name" class="form-control">
                        @error('street')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Enter User Password" class="form-control">
                        @error('password')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="Enter Password Again" class="form-control">
                        @error('password_confirmation')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary">Submit</button>

        </div>
       </center>
    </form>
@endsection
