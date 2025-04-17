@extends('layouts.dashboard.app')
@section('title')
    Create post
@endsection
@section('body')
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
       <center>
        <div class="card-body shadow mb-4 col-10 ">
            <a style="margin-left: 90ch" class="btn btn-primary" href="{{ route('admin.posts.index') }}" >Show Posts</a>

            <h2>Create New Post</h2><br>
            @if (session()->has('errors'))
                <div class="alert alert-danger">
                  <ul>
                    @foreach (session('errors')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text"  value="{{ @old('title') }}" name="title" placeholder="Enter Post Title" class="form-control">
                        @error('title')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <textarea  name="small_desc"  value="{{ @old('small_desc') }}" placeholder="Enter Small Description" class="form-control"></textarea>
                        @error('small_desc')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <textarea id="postContent" value="{{ @old('desc') }}" name="desc" placeholder="Enter Description" class="form-control"></textarea>
                        @error('desc')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input multiple id="postImage" type="file" name="images[]"  class="form-control">
                        @error('images')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
              
            </div>
           
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="category_id" class="form-control">
                            <option selected disabled>select Category</option>

                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            

                        </select>
                        @error('category_id')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
               
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option selected >select status</option>
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
                        <select name="comment_able" class="form-control">
                            <option selected >select Comment Able Status</option>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                        @error('comment_able')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    </div>
                </div>
            </div>
           
            <br><br>
            <button type="submit" class="btn btn-primary">Create Post</button>

        </div>
       </center>
    </form>
@endsection

@push('js')
<script>
    $(function() {
           $('#postImage').fileinput({
               theme: 'fa5',
               allowedFiletypes: ['image'],
               maxFileCount: 5,
               showUpload: false,
           });
           $('#postContent').summernote({
               height: 300,
           });

       });
</script>
@endpush
