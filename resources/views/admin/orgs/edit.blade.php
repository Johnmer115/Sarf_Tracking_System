@extends('admin.layout')

@section('title', 'Edit Organization | SARF Tracking')
@section('page-title', 'Edit Organization')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-pen-to-square"></i> Edit Organization</div>
                    <p class="form-copy">Update the organization details below.</p>
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

                <form action="{{ route('admin.orgs.update', $organization->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <div class="form-group">
                            <label class="form-label" for="name">Organization Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name', $organization->name) }}"
                                placeholder="Enter organization name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="department">Department</label>
                            <select class="form-control" id="department" name="department_id" required>
                                <option value="">Select department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id', $organization->department_id) == $department->id)>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch</label>
                            <select class="form-control" id="branch_id" name="branch_id" required>
                                <option value="">Select branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @selected(old('branch_id', $department->branch_id) == $branch->id)>
                                        {{ $branch->name }}{{ $branch->code ? ' (' . $branch->code . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-filter" href="{{ route('admin.department.index') }}">Back</a>
                        <button type="submit" class="btn btn-add" @disabled($branches->isEmpty())>Update Department</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
