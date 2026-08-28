@extends('layouts.admin')

@section('title', 'Profile Information')

@section('content')

    {{-- BREADCRUMB CARD --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <span class="active-crumb">Profile Information</span>
    </div>

    @if (session('status') === 'profile-updated')
        <div style="display: flex; align-items: center; gap: 10px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 12px 16px; border-radius: 10px; font-size: 13.5px; font-weight: 600; margin-bottom: 20px;">
            <span data-lucide="check-circle" style="width: 18px; height: 18px; color: #10b981;"></span>
            <span>Profil berhasil diperbarui.</span>
        </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="main-card" style="max-width: 680px;">
        @include('profile.partials.update-profile-information-form')
    </div>

@endsection
