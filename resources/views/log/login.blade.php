@extends('log.layout')

@section('content')
<section class="login-shell">
    <div class="login-panel">
        <div class="login-brand">
            <img src="{{ asset('img/logo/arellano_logo.png') }}" alt="Arellano University logo" class="login-logo">
            <div>
                <h1>Login </h1>
                <p class="login-kicker">AU SARF Tracking</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="login-alert" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="account">Username or Email</label>
                <input
                    type="text"
                    id="account"
                    name="account"
                    value="{{ old('account') }}"
                    required
                    autofocus
                    placeholder="Enter your username or email"
                >
                @error('account')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Enter your password"
                >
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-options">

                <label class="checkbox-row checkbox-row--secondary" for="show-password">
                    <input type="checkbox" id="show-password">
                    <span>Show password</span>
                </label>
            </div>

            <button type="submit" class="login-button">
                Sign In
            </button>
        </form>
    </div>
</section>

<script>
    document.getElementById('show-password').addEventListener('change', function (event) {
        document.getElementById('password').type = event.target.checked ? 'text' : 'password';
    });
</script>
@endsection
