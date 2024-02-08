@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-header">Manage Roles</div>
    <div class="card-body">
        <!-- @can('create-role')
            <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Role</a>
        @endcan -->
        <table class="table table-striped jambo_table bulk_action rolesTable">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                @php if($role->name!="Super Admin" && $role->name!="Member"){ @endphp
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $role->name }}</td>
                    <td>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('roles.show', $role->id) }}" class="edit btn btn-info btn-sm"><i class="bi bi-eye"></i> View</a>
                    
                            @if ($role->name!='Super Admin')
                                @can('edit-role')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="edit btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                @endcan

                                <!-- @can('delete-role')
                                    @if ($role->name!=Auth::user()->hasRole($role->name))
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> Delete</button>
                                    @endif
                                @endcan -->
                            @endif

                        </form>
                    </td>
                </tr>
                @php } @endphp
                @empty
                    <td colspan="3">
                        <span class="text-danger">
                            <strong>No Role Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>
        {{ $roles->links() }}


    </div>
</div>
@endsection