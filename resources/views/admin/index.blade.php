@extends('admin.layout')

@section('title', 'Dashboard | SARF Tracking') 
@section('page-title', 'Dashboard') 

@section('content')
    <section class="panel" style="padding: 24px;">
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p>Your account was validated as an admin, so you were redirected here after login.</p>
    </section>
@endsection
