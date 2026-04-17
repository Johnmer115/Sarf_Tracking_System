@extends('log.layout')

@section('content')
<section class="login-shell">
    <div class="login-panel login-panel--wide">
        <div class="login-brand">
            <img src="{{ asset('img/logo/arellano_logo.png') }}" alt="Arellano University logo" class="login-logo">
            <div>
                <h1>Register</h1>
                <p class="login-kicker">AU SARF Tracking — Organization Registration</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="login-alert" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="login-form">
            @csrf

            {{-- Account Section --}}
            <p class="reg-section-label">Account Details</p>

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    placeholder="e.g. ComputerStudiesSociety"
                >
                @error('username')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="reg-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Minimum 6 characters"
                    >
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="Re-enter password"
                    >
                </div>
            </div>

            {{-- Organization Section --}}
            <p class="reg-section-label">Organization Details</p>

            <div class="form-group">
                <label for="org_name">Organization Name</label>
                <input
                    type="text"
                    id="org_name"
                    name="org_name"
                    value="{{ old('org_name') }}"
                    required
                    placeholder="e.g. Computer Science Studies Society"
                >
                @error('org_name')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="reg-row">
                <div class="form-group">
                    <label for="branch_id">Branch</label>
                    <select id="branch_id" name="branch_id" required>
                        <option value="">-- Select Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select id="department_id" name="department_id" required>
                        <option value="">-- Select Branch First --</option>
                    </select>
                    @error('department_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="login-button">
                Submit Registration
            </button>

            <p class="login-register-link">
                Already have an account?
                <a href="{{ route('login') }}">Sign In</a>
            </p>
        </form>
    </div>
</section>

<script>
    // Branch → Department cascade
    const branchSelect = document.getElementById('branch_id');
    const deptSelect   = document.getElementById('department_id');
    const oldDeptId    = "{{ old('department_id') }}";

    branchSelect.addEventListener('change', loadDepartments);

    // Auto-load departments if old value exists (validation redirect)
    if (branchSelect.value) {
        loadDepartments();
    }

    function loadDepartments() {
        const branchId = branchSelect.value;
        deptSelect.innerHTML = '<option value="">Loading...</option>';

        if (!branchId) {
            deptSelect.innerHTML = '<option value="">-- Select Branch First --</option>';
            return;
        }

        fetch(`{{ route('departments.by.branch') }}?branch_id=${branchId}`)
            .then(res => res.json())
            .then(departments => {
                if (departments.length === 0) {
                    deptSelect.innerHTML = '<option value="">No departments in this branch</option>';
                    return;
                }
                deptSelect.innerHTML = '<option value="">-- Select Department --</option>';
                departments.forEach(dept => {
                    const selected = dept.id == oldDeptId ? 'selected' : '';
                    deptSelect.innerHTML += `<option value="${dept.id}" ${selected}>${dept.name}</option>`;
                });
            })
            .catch(() => {
                deptSelect.innerHTML = '<option value="">Error loading departments</option>';
            });
    }
</script>
@endsection
