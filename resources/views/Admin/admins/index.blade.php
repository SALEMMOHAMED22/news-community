@extends('layouts.dashboard.app')

@section('title')
    Admins
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><b>Admins</b></h1>
        <p style="color: blue" class="mb-4">A dynamic table that displays users from a database with features such as
            searching, sorting,
            specifying a specific number of rows, and displaying by status...</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Admins Management</h6>
            </div>
            {{-- Filter page --}}
            @include('Admin.admins.filter')
            {{-- End Filter page --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created_At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created_At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->authorization->role ?? 'No Role'}}</td>
                                    <td>{{ $admin->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $admin->created_at->format('y-m-d h:m a') }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Are You Sure To Delete admin?')){document.getElementById('delete_admin_{{ $admin->id }}').submit()}return false "
                                            class="fa fa-trash"></a>
                                        <a href="{{ route('admin.admins.changeStatus', $admin->id) }}"
                                            class="fa @if ($admin->status == 1) fa-stop @else fa-play @endif"></a>
                                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="fa fa-edit"></a>
                                    </td>
                                </tr>

                                <form id="delete_admin_{{ $admin->id }}"
                                    action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                </form>

                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No admins </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $admins->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
