@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Companies</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('companies.create') }}" class="btn btn-primary">Add New Company</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="companies-table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                    <tr>
                        <td>
                            @if($company->logo)
                                <img src="{{ asset($company->logo) }}" alt="{{ $company->name }} Logo" class="img-thumbnail" style="max-width: 50px; height: auto;">
                            @else
                                <span class="text-muted">No Logo</span>
                            @endif
                        </td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('companies.show', $company) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('companies.edit', $company) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('companies.destroy', $company) }}" method="POST" class="d-inline">
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
        {{ $companies->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#companies-table').DataTable({
            "pageLength": 10,
            "order": [[1, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 4] }
            ]
        });
    });
</script>
@endpush 