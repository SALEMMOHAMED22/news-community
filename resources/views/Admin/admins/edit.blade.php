@extends('layouts.dashboard.app')
@section('title')
    Edit Admin
@endsection

@section('body')
    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.admins.update' , $admin->id) }}" method="post" >
            @csrf
            @method('PUT')
            <div class="card-body shadow mb-4" style="min-width: 75ch">
            <div class="row">
                <div class="col-9">
                    <h2> Edit  Admin</h2>
                </div>
                <div class="col-3">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">Back To Admins</a>
                </div>
            </div><br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                           Enter Name: <input type="text" value="{{ $admin->name }}" name="name" placeholder="Enter Admin name" class="form-control">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Enter Username<input type="text" value="{{ $admin->username }}" name="username" placeholder="Enter Admin Username" class="form-control">
                            @error('username')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Enter Email:<input type="email" value="{{ $admin->email }}" name="email" placeholder="Enter Admin Email" class="form-control">
                            @error('email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Select Status:<select name="status" class="form-control">
                                <option selected disabled>Select Status</option>
                                <option value="1" @selected($admin->status==1)>Active</option>
                                <option value="0"  @selected($admin->status==0)>Not Active</option>
                            </select>
                            @error('status')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Select Role:<select name="role_id" class="form-control">
                                <option selected disabled>Select Role</option>
                                @forelse ($authorizations as $authorization)
                                <option value="{{ $authorization->id }}" @selected($admin->role_id == $authorization->id)>{{ $authorization->role }}</option>
                                @empty
                                    <option selected disabled>NO Authorizations</option>
                                @endforelse
                            </select>
                            @error('status')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Select Role:<select name="role_id" class="form-control">
                                <option selected disabled>Select Role</option>
                                 @forelse ($authorizations as $authorization )
                                 <option value="{{ $authorization->id }}">{{ $authorization->role }}</option>
                                 @empty
                                  <option disabled selected> No Roles</option>
                                 @endforelse

                            </select>
                            @error('status')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Enter Password:<input type="password" name="password" placeholder="Enter Password" class="form-control">
                            @error('password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            Enter Confirm Password<input type="password" name="password_confirmation" placeholder="Enter Password again"
                                class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Admin</button>
            </div>

        </form>
    </div>
@endsection