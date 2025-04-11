@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Company Details</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('companies.edit', $company) }}" class="btn btn-warning">Edit Company</a>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if($company->logo)
                        <div class="text-center mb-3">
                            <img src="{{ $company->logo }}" alt="Company Logo" style="max-width: 200px;">
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">Name</th>
                            <td>{{ $company->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $company->email ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td>
                                @if($company->website)
                                    <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Employees</h5>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">Add Employee</a>
                </div>
                <div class="card-body">
                    @if($company->employees->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($company->employees as $employee)
                                        <tr>
                                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                            <td>{{ $employee->email ?: 'N/A' }}</td>
                                            <td>{{ $employee->phone ?: 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center mb-0">No employees found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 