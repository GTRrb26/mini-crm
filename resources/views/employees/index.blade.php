@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Employees</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Add New Employee</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="employees-table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>
                            <a href="{{ route('companies.show', $employee->company) }}">
                                {{ $employee->company->name }}
                            </a>
                        </td>
                        <td>{{ $employee->email ?: 'N/A' }}</td>
                        <td>{{ $employee->phone ?: 'N/A' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $employees->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#employees-table').DataTable({
            "pageLength": 10,
            "order": [[0, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [5] }
            ]
        });
    });
</script>
@endpush 