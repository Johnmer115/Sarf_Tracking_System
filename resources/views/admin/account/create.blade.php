@extends('admin.layout')

@section('title', 'Create Account | SARF Tracking') 
@section('page-title', 'Create Account') 

@section('content')
    <section >
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <div class="form-panel" >
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-user-plus"></i> Add New Account</div>
                    <p class="form-copy">Fill in the required details below to create an account.</p>
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

                        <div class="form-group">
                            <label class="form-label" for="usertype">User Type</label>
                            <select class="form-control" id="usertype" name="usertype" required>
                                <option value="admin" @selected(old('usertype') === 'admin')>Admin</option>
                                <option value="user" @selected(old('usertype') === 'user')>User</option>
                            </select>
                        </div>

                        {{-- Hide by default, only show if old value was 'user' --}}
                        <div class="form-group" id="organization-group" style="{{ old('usertype') === 'user' ? '' : 'display:none;' }}">
                            <label class="form-label" for="organization">Organization</label>
                            <input
                                type="text"
                                class="form-control"
                                id="organization"
                                name="organization"
                                value="{{ old('organization') }}"
                                placeholder="Enter organization"
                            >
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
            const usertypeSelect = document.getElementById('usertype');
            const orgGroup = document.getElementById('organization-group');

            usertypeSelect.addEventListener('change', function () {
                orgGroup.style.display = this.value === 'user' ? '' : 'none';

                // Clear the field when hidden so it doesn't submit stale data
                if (this.value !== 'user') {
                    document.getElementById('organization').value = '';
                }
            });
        </script>

        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;

                // Change icon
                this.innerHTML = type === 'password'
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        </script>
    </section>
@endsection
