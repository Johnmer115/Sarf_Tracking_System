@extends('admin.layout')

@section('title', 'View Account | SARF Tracking')
@section('page-title', 'View Account')

@section('content')
    <section>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <div class="form-panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title"><i class="fas fa-id-card"></i> Account Details</div>
                    <p class="form-copy">View the saved account information below.</p>
                </div>
            </div>

            <div class="form-body">
                <div>
                    <div class="form-group">
                        <label class="form-label" for="account_id">Account ID</label>
                        <input
                            type="text"
                            class="form-control"
                            id="account_id"
                            value="#{{ str_pad($account->id, 3, '0', STR_PAD_LEFT) }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            value="{{ $account->username }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usertype">User Type</label>
                        <input
                            type="text"
                            class="form-control"
                            id="usertype"
                            value="{{ ucfirst($account->usertype) }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="created_at">Created Date</label>
                        <input
                            type="text"
                            class="form-control"
                            id="created_at"
                            value="{{ $account->created_at?->format('F d, Y h:i A') ?? 'N/A' }}"
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">Status</label>
                        <input
                            type="text"
                            class="form-control"
                            id="status"
                            value="{{ ucfirst($account->status) }}"
                            readonly
                        >
                    </div>

                    @if ($account->usertype === 'user')
                        <div class="form-group">
                            <label class="form-label" for="organization">Organization</label>
                            <input
                                type="text"
                                class="form-control"
                                id="organization"
                                value="{{ $account->organization ?: 'No organization assigned' }}"
                                readonly
                            >
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <a class="btn btn-filter" href="{{ route('admin.account.index') }}">Back to List</a>
                </div>
            </div>
        </div>
    </section>
@endsection
