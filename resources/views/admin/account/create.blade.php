@extends('admin.layout')

@section('title', 'Create Account | SARF Tracking')
@section('page-title', 'Create Account')

@section('content')
    <section>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-user-plus"></i> Add New Account</div>
                    <p class="form-copy">Fill in the required details below to create an account. Admin-created accounts are immediately active.</p>
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

                <form action="{{ route('admin.account.store') }}" method="POST">
                    @csrf

                    <div>
                        {{-- Username --}}
                        <div class="form-group">
                            <label class="form-label" for="username">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Enter username"
                                autocomplete="username"
                                required
                            >
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <div class="password-wrapper">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Minimum 6 characters"
                                    autocomplete="new-password"
                                    required
                                >
                                <span id="togglePassword" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        {{-- User Type --}}
                        <div class="form-group">
                            <label class="form-label" for="usertype">User Type</label>
                            <select class="form-control" id="usertype" name="usertype" required>
                                <option value="admin" @selected(old('usertype') === 'admin')>Admin</option>
                                <option value="user"  @selected(old('usertype') === 'user')>User</option>
                            </select>
                        </div>

                        {{-- Organization fields — only visible when usertype = user --}}
                        <div id="org-fields" style="{{ old('usertype') === 'user' ? '' : 'display:none;' }}">

                            {{-- Organization Name --}}
                            <div class="form-group">
                                <label class="form-label" for="org_name">Organization Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="org_name"
                                    name="org_name"
                                    value="{{ old('org_name') }}"
                                    placeholder="e.g. Computer Studies Society"
                                >
                            </div>

                            {{-- Branch --}}
                            <div class="form-group">
                                <label class="form-label" for="branch_id">Branch</label>
                                <select class="form-control" id="branch_id" name="branch_id">
                                    <option value="">-- Select Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Department (populated by JS based on branch) --}}
                            <div class="form-group">
                                <label class="form-label" for="department_id">Department</label>
                                <select class="form-control" id="department_id" name="department_id">
                                    <option value="">-- Select Branch First --</option>
                                    @if(old('department_id') && old('branch_id'))
                                        {{-- Re-populate on validation error --}}
                                        @foreach($departments ?? [] as $dept)
                                            <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-filter" href="{{ route('admin.account.index') }}">Back</a>
                        <button type="submit" class="btn btn-add">Save Account</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // --- Usertype toggle ---
            const usertypeSelect = document.getElementById('usertype');
            const orgFields      = document.getElementById('org-fields');

            usertypeSelect.addEventListener('change', function () {
                orgFields.style.display = this.value === 'user' ? '' : 'none';
                if (this.value !== 'user') {
                    document.getElementById('org_name').value     = '';
                    document.getElementById('branch_id').value    = '';
                    document.getElementById('department_id').innerHTML = '<option value="">-- Select Branch First --</option>';
                }
            });

            // --- Branch → Department cascade ---
            document.getElementById('branch_id').addEventListener('change', function () {
                const branchId = this.value;
                const deptSelect = document.getElementById('department_id');

                deptSelect.innerHTML = '<option value="">Loading...</option>';

                if (!branchId) {
                    deptSelect.innerHTML = '<option value="">-- Select Branch First --</option>';
                    return;
                }

                fetch(`{{ route('departments.by.branch') }}?branch_id=${branchId}`)
                    .then(res => res.json())
                    .then(departments => {
                        if (departments.length === 0) {
                            deptSelect.innerHTML = '<option value="">No departments found</option>';
                            return;
                        }
                        deptSelect.innerHTML = '<option value="">-- Select Department --</option>';
                        departments.forEach(dept => {
                            deptSelect.innerHTML += `<option value="${dept.id}">${dept.name}</option>`;
                        });
                    })
                    .catch(() => {
                        deptSelect.innerHTML = '<option value="">Error loading departments</option>';
                    });
            });

            // --- Password toggle ---
            document.getElementById('togglePassword').addEventListener('click', function () {
                const input = document.getElementById('password');
                const type  = input.type === 'password' ? 'text' : 'password';
                input.type  = type;
                this.innerHTML = type === 'password'
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        </script>
    </section>
@endsection
