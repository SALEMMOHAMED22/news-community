@extends('layouts.dashboard.app')

@section('title')
    Posts
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><b>posts</b></h1>
        <p style="color: blue" class="mb-4">A dynamic table that displays posts from a database with features such as searching, sorting,
            specifying a specific number of rows, and displaying by status...</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Posts Management</h6>
            </div>
           {{-- Filter page --}}
           @include('Admin.posts.filter')
           {{-- End Filter page --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->user->name?? $post->admin->name }}</td>
                                    <td>{{ $post->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $post->num_of_views }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Are You Sure To Delete post?')){document.getElementById('delete_post_{{ $post->id }}').submit()}return false "
                                            class="fa fa-trash"></a>
                                        <a href="{{ route('admin.posts.changeStatus' , $post->id) }}" class="fa @if($post->status ==1)fa-stop @else fa-play @endif"></a>
                                        <a href="{{ route('admin.posts.show' , ['post'=>$post->id , 'page' => request()->page]) }}" class="fa fa-eye"></a>
                                        @if ($post->user_id == null)
                                        <a href="{{ route('admin.posts.edit' , $post->id) }}" class="fa fa-edit"></a>
                                            
                                        @endif
                                    </td>
                                </tr>

                                <form id="delete_post_{{ $post->id }}"
                                    action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                </form>

                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No posts </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $posts->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
