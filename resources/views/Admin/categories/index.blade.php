@extends('layouts.dashboard.app')

@section('title')
    Categories
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><b>Categories</b></h1>
        <p style="color: blue" class="mb-4">A dynamic table that displays categories from a database with features such as
            searching, sorting,
            specifying a specific number of rows, and displaying by status...</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories Management</h6>
            </div>
            {{-- Filter Page --}}
            @include('Admin.users.filter')
            {{-- End Filter Page --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created_At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created_At</th>
                                <th>Actions</th>

                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $category->posts_count }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    {{-- Td for Actions --}}
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Are You Sure To Delete category?')){document.getElementById('delete_category_{{ $category->id }}').submit()}return false "
                                            class="fa fa-trash"></a>
                                        <a href="{{ route('admin.categories.changeStatus', $category->id) }}"
                                            class="fa @if ($category->status == 1) fa-stop @else fa-play @endif"></a>
                                        <a href="javascript:void(0)" class="fa fa-edit"data-toggle="modal"
                                            data-target="#edit-category"></a>
                                    </td>
                                </tr>

                                <form id="delete_category_{{ $category->id }}"
                                    action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                {{-- Update Category Modal --}}
                               @include('Admin.categories.edit')
                                {{-- End Update Category Modal --}}

                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No Categories </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
        {{-- Add Category Modal --}}

        @include('Admin.categories.create')

        {{-- End Add Category Modal --}}
    </div>
@endsection
