@extends('admin.layout')

@section('title', 'Create Department | SARF Tracking')
@section('page-title', 'Create Department')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-sitemap"></i> Add New Department</div>
                    <p class="form-copy">Fill in the required details below to create a department.</p>
                </div>
            </div>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.department.store') }}" method="POST">
                    @csrf

                    <div>
                        <div class="form-group">
                            <label class="form-label" for="name">Department Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter department name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="dept_dean">Department Dean</label>
                            <input
                                type="text"
                                class="form-control"        
                                id="dept_dean"
                                name="dept_dean"
                                value="{{ old('dept_dean') }}"
                                placeholder="Enter department dean"
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch</label>
                            <select class="form-control" id="branch_id" name="branch_id" required>
                                <option value="">Select branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>
                                        {{ $branch->name }}{{ $branch->code ? ' (' . $branch->code . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-filter" href="{{ route('admin.department.index') }}">Back</a>
                        <button type="submit" class="btn btn-add" @disabled($branches->isEmpty())>Save Department</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
