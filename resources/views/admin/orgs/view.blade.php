@extends('admin.layout')

@section('title', 'View Organization | SARF Tracking')
@section('page-title', 'View Organization')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-id-card"></i> Organization Details</div>
                    <p class="form-copy">View the saved organization information below.</p>
                </div>
            </div>

            <div class="form-body">
                <div>
                    <div class="form-group">
                        <label class="form-label" for="org_code">Organization Code</label>
                        <input
                            type="text"
                            class="form-control"
                            id="org_code"
                            value="{{ $organization->code }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="org_name">Organization Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="org_name"
                            value="{{ $organization->name }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="account_username">Account</label>
                        <input
                            type="text"
                            class="form-control"
                            id="account_username"
                            value="{{ $organization->account->username ?? 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="department_id">Department</label>
                        <input
                            type="text"
                            class="form-control"
                            id="department_id"
                            value="{{ $organization->department->name ?? 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="branch_id">Branch</label>
                        <input
                            type="text"
                            class="form-control"
                            id="branch_id"
                            value="{{ $organization->department?->branch?->name ? $organization->department->branch->name . ($organization->department->branch->code ? ' (' . $organization->department->branch->code . ')' : '') : 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="branch_location">Branch Location</label>
                        <input
                            type="text"
                            class="form-control"
                            id="branch_location"
                            value="{{ $organization->department?->branch?->location ?? 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="created_at">Created Date</label>
                        <input
                            type="text"
                            class="form-control"
                            id="created_at"
                            value="{{ $organization->created_at?->format('F d, Y h:i A') ?? 'N/A' }}"
                            readonly
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-filter" href="{{ route('admin.orgs.index') }}">Back to List</a>
                </div>
            </div>
        </div>
    </section>
@endsection
