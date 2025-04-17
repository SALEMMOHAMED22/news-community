@extends('layouts.dashboard.app')

@section('title')
    Users
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><b>Users</b></h1>
        <p style="color: blue" class="mb-4">A dynamic table that displays users from a database with features such as searching, sorting,
            specifying a specific number of rows, and displaying by status...</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users Management</h6>
            </div>
           {{-- Filter page --}}
           @include('Admin.users.filter')
           {{-- End Filter page --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Country</th>
                                <th>Created_At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Country</th>
                                <th>Created_At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $user->country }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Are You Sure To Delete User?')){document.getElementById('delete_user_{{ $user->id }}').submit()}return false "
                                            class="fa fa-trash"></a>
                                        <a href="{{ route('admin.users.changeStatus' , $user->id) }}" class="fa @if($user->status ==1)fa-stop @else fa-play @endif"></a>
                                        <a href="{{ route('admin.users.show' , $user->id) }}" class="fa fa-eye"></a>
                                    </td>
                                </tr>

                                <form id="delete_user_{{ $user->id }}"
                                    action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                </form>

                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No Users </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
