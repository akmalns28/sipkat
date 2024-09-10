@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column gap-2">
                        <div class="divider text-start my-0">
                            <div class="divider-text">Akun</div>
                        </div>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" id="btn-profile">
                                <i class="bx bx-sm bx-user me-1_5"></i> Ubah Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" id="btn-password">
                                <i class="bx bx-sm bx-user me-1_5"></i> Ubah Kata Sandi
                            </a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off me-2 text-danger"></i>
                                <span class="align-middle text-danger">Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body" id="content-area">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const profileLink = document.getElementById('btn-profile');
    const passwordLink = document.getElementById('btn-password');
    const contentArea = document.getElementById('content-area');

    function loadContent(url) {
        if (url.includes('password')) {
            passwordLink.classList.add('active');
            profileLink.classList.remove('active');
            contentArea.innerHTML = `
                <h3>Ubah Kata Sandi</h3>
                <form method="POST" action="{{ route('user.updatePassword', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="current_password">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="new_password">Kata Sandi Baru</label>
                        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Kata Sandi</button>
                </form>
            `;
        } else if (url.includes('profil')) {
            profileLink.classList.add('active');
            passwordLink.classList.remove('active');
            contentArea.innerHTML = `
                <h3>Ubah Profil</h3>
                <form method="POST" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="nik">NIP</label>
                            <input type="number" min="0" class="form-control @error('nik') is-invalid @enderror" value="{{ $user->nik }}" id="nik" name="nik">
                            @error('nik')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" id="name" name="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}" id="username" name="username">
                            @error('username')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" id="email" name="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control d-none @error('role') is-invalid @enderror" value="{{ $user->role }}" id="role" name="role">
                            @error('role')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profil</button>
                </form>
            `;
        }
    }

    // Load initial content based on URL
    loadContent(window.location.href);

    // Event listeners for link clicks
    profileLink.addEventListener('click', function() {
        loadContent('profil');
        history.pushState(null, '', '/setting/ubah-profil');
    });

    passwordLink.addEventListener('click', function() {
        loadContent('password');
        history.pushState(null, '', '/setting/ubah-password');
    });
});

    </script>
@endpush
