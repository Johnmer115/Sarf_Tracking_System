@extends('admin.layout')

@section('title', 'Create Branch | SARF Tracking')
@section('page-title', 'Create Branch')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-code-branch"></i> Add New Branch</div>
                    <p class="form-copy">Fill in the required details below to create a branch.</p>
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

                <form action="{{ route('admin.branch.store') }}" method="POST">
                    @csrf

                    <div>
                        <div class="form-group">
                            <label class="form-label" for="name">Branch Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter branch name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="location">Location</label>
                            <textarea
                                class="form-control"
                                id="location"
                                name="location"
                                rows="4"
                                placeholder="Enter branch location"
                                required
                            >{{ old('location') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-filter" href="{{ route('admin.branch.index') }}">Back</a>
                        <button type="submit" class="btn btn-add">Save Branch</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
