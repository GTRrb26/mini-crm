@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Employee Details</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">Edit Employee</a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">First Name</th>
                    <td>{{ $employee->first_name }}</td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td>{{ $employee->last_name }}</td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td>
                        <a href="{{ route('companies.show', $employee->company) }}">
                            {{ $employee->company->name }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $employee->email ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $employee->phone ?: 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection 