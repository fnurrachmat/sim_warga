<x-guest-layout>
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-users me-2"></i>
                Sistem Informasi Warga
            </h4>
        </div>
        <div class="card-body p-4">
            <h5 class="text-center mb-4">Silakan Login</h5>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="mb-3">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <x-primary-button class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            <i class="fas fa-key me-1"></i>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
        }
        .input-group-text {
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
    </style>
    @endpush
</x-guest-layout>
