@extends('admin.layout')

@section('title', 'View Department | SARF Tracking')
@section('page-title', 'View Department')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-id-card"></i> Department Details</div>
                    <p class="form-copy">View the saved department information below.</p>
                </div>
            </div>

            <div class="form-body">
                <div>
                    <div class="form-group">
                        <label class="form-label" for="department_code">Department Code</label>
                        <input
                            type="text"
                            class="form-control"
                            id="department_code"
                            value="{{ $department->code }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="department_name">Department Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="department_name"
                            value="{{ $department->name }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="department_dean">Department Dean</label>
                        <input
                            type="text"
                            class="form-control"
                            id="department_dean"
                            value="{{ $department->dept_dean ?? 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="department_branch">Branch</label>
                        <input
                            type="text"
                            class="form-control"
                            id="department_branch"
                            value="{{ $department->branch?->name ? $department->branch->name . ($department->branch->code ? ' (' . $department->branch->code . ')' : '') : 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="branch_location">Branch Location</label>
                        <input
                            type="text"
                            class="form-control"
                            id="branch_location"
                            value="{{ $department->branch?->location ?? 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="created_at">Created Date</label>
                        <input
                            type="text"
                            class="form-control"
                            id="created_at"
                            value="{{ $department->created_at?->format('F d, Y h:i A') ?? 'N/A' }}"
                            readonly
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-filter" href="{{ route('admin.department.index') }}">Back to List</a>
                </div>
            </div>
        </div>
    </section>
@endsection
