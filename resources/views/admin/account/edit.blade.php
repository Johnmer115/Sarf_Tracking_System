@extends('admin.layout')

@section('title', 'Edit Account | SARF Tracking')
@section('page-title', 'Edit Account')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-user-pen"></i> Edit Account</div>
                    <p class="form-copy">Update the account details below.</p>
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

                <form action="{{ route('admin.account.update', $account->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <div class="form-group">
                            <label class="form-label" for="username">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="{{ old('username', $account->username) }}"
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
                                    placeholder="Leave blank to keep current password"
                                    autocomplete="new-password"
                                >
                                <span id="togglePassword" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="usertype">User Type</label>
                            <select class="form-control" id="usertype" name="usertype" required>
                                <option value="admin" @selected(old('usertype', $account->usertype) === 'admin')>Admin</option>
                                <option value="user" @selected(old('usertype', $account->usertype) === 'user')>User</option>
                            </select>
                        </div>

                        <div class="form-group" id="organization-group" style="{{ old('usertype', $account->usertype) === 'user' ? '' : 'display:none;' }}">
                            <label class="form-label" for="organization">Organization</label>
                            <input
                                type="text"
                                class="form-control"
                                id="organization"
                                name="organization"
                                value="{{ old('organization', $account->organization) }}"
                                placeholder="Enter organization"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active" @selected(old('status', $account->status) === 'active')>Active</option>
                                <option value="inactive" @selected(old('status', $account->status) === 'inactive')>Inactive</option>
                            </select>
                        </div> 
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-filter" href="{{ route('admin.account.index') }}">Back</a>
                        <button type="submit" class="btn btn-add">Update Account</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const usertypeSelect = document.getElementById('usertype');
            const organizationGroup = document.getElementById('organization-group');
            const organizationInput = document.getElementById('organization');

            usertypeSelect.addEventListener('change', function () {
                organizationGroup.style.display = this.value === 'user' ? '' : 'none';

                if (this.value !== 'user') {
                    organizationInput.value = '';
                }
            });
        </script>

        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;

                this.innerHTML = type === 'password'
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        </script>
    </section>
@endsection
