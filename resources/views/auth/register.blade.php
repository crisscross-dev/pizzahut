@extends('layouts.shop')

@section('title', 'Register - Pizzeria')

@section('content')
<style>
    .auth-page {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px 100px;
    }

    .auth-container {
        width: 100%;
        max-width: 440px;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .auth-logo {
        width: 64px;
        height: 64px;
        background: var(--gradient-warm);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 20px;
        box-shadow: 0 8px 24px rgba(230, 57, 70, 0.3);
        overflow: hidden;
    }

    .auth-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .auth-title {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        background: var(--gradient-warm);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.5;
    }

    .auth-card {
        background: var(--dark-card);
        border-radius: var(--border-radius);
        padding: 32px;
        box-shadow: var(--shadow-card);
        border: 1px solid rgba(255, 255, 255, 0.04);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 24px 0;
        color: var(--text-muted);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    }

    .auth-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: var(--border-radius-sm);
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        font-family: inherit;
        transition: var(--transition-smooth);
        text-decoration: none;
        min-height: 54px;
        -webkit-tap-highlight-color: transparent;
    }

    .auth-btn:focus {
        outline: 2px solid var(--primary-orange);
        outline-offset: 2px;
    }

    .auth-btn.primary {
        background: var(--gradient-warm);
        color: white;
        box-shadow: 0 4px 16px rgba(230, 57, 70, 0.25);
    }

    .auth-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(230, 57, 70, 0.35);
    }

    .auth-btn.primary:active {
        transform: translateY(0);
    }

    .auth-btn.google {
        background: var(--dark-surface);
        color: var(--text-light);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .auth-btn.google:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .auth-btn.google:active {
        transform: translateY(0);
    }

    .auth-btn.google i {
        font-size: 18px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 8px;
        letter-spacing: 0.2px;
    }

    .input-wrapper {
        position: relative;
    }

    .form-input {
        width: 100%;
        padding: 16px 18px;
        background: var(--dark-surface);
        border: 2px solid transparent;
        border-radius: var(--border-radius-sm);
        color: var(--text-light);
        font-size: 15px;
        font-family: inherit;
        transition: var(--transition-smooth);
        min-height: 54px;
        -webkit-appearance: none;
        appearance: none;
    }

    .form-input::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-orange);
        background: rgba(247, 127, 0, 0.05);
    }

    .form-input:hover:not(:focus) {
        border-color: rgba(255, 255, 255, 0.1);
    }

    .input-wrapper .form-input {
        padding-right: 52px;
    }

    .password-toggle {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        border-radius: 10px;
        transition: var(--transition-smooth);
        -webkit-tap-highlight-color: transparent;
    }

    .password-toggle:hover {
        color: var(--text-light);
        background: rgba(255, 255, 255, 0.05);
    }

    .password-toggle:focus {
        outline: none;
        color: var(--primary-orange);
    }

    .password-toggle i {
        font-size: 16px;
    }

    .password-hint {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .password-hint i {
        font-size: 11px;
    }

    .password-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .auth-footer {
        margin-top: 24px;
        text-align: center;
        font-size: 15px;
        color: var(--text-muted);
    }

    .auth-footer a {
        color: var(--primary-orange);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition-smooth);
    }

    .auth-footer a:hover {
        color: var(--primary-red);
        text-decoration: underline;
    }

    .alert-error {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(220, 53, 69, 0.12);
        border: 1px solid rgba(220, 53, 69, 0.25);
        color: #ffb3ba;
        border-radius: var(--border-radius-sm);
        padding: 14px 16px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.5;
    }

    .alert-error i {
        font-size: 18px;
        flex-shrink: 0;
    }

    .terms-text {
        font-size: 13px;
        color: var(--text-muted);
        text-align: center;
        margin-top: 16px;
        line-height: 1.6;
    }

    .terms-text a {
        color: var(--primary-orange);
        text-decoration: none;
    }

    .terms-text a:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .auth-page {
            padding: 30px 16px 120px;
            align-items: flex-start;
            padding-top: 60px;
        }

        .auth-card {
            padding: 24px 20px;
        }

        .auth-title {
            font-size: 28px;
        }

        .auth-logo {
            width: 56px;
            height: 56px;
            font-size: 24px;
        }

        .form-input,
        .auth-btn {
            min-height: 52px;
            padding: 14px 16px;
        }

        .input-wrapper .form-input {
            padding-right: 48px;
        }

        .password-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('image/logo.jfif') }}" alt="Logo">
            </div>
            <h1 class="auth-title">Create account</h1>
            <p class="auth-subtitle">Join us and start ordering delicious pizzas today</p>
        </div>

        <div class="auth-card">
            @if (session('error'))
            <div class="alert-error" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert-error" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <a class="auth-btn google" href="{{ route('auth.google') }}" aria-label="Continue with Google">
                <i class="fab fa-google"></i>
                Continue with Google
            </a>

            <div class="auth-divider">or</div>

            <form method="POST" action="{{ route('register.submit') }}" autocomplete="on">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        placeholder="John Doe"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        aria-describedby="name-help">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        inputmode="email"
                        aria-describedby="email-help">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Create a password"
                            required
                            autocomplete="new-password"
                            minlength="8"
                            aria-describedby="password-hint">
                        <button
                            type="button"
                            class="password-toggle"
                            aria-label="Toggle password visibility"
                            onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-hint" id="password-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Must be at least 8 characters</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Repeat your password"
                            required
                            autocomplete="new-password"
                            aria-describedby="confirm-help">
                        <button
                            type="button"
                            class="password-toggle"
                            aria-label="Toggle password confirmation visibility"
                            onclick="togglePassword('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-btn primary">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>

                <p class="terms-text">
                    By creating an account, you agree to our
                    <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </p>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            button.setAttribute('aria-label', 'Hide password');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            button.setAttribute('aria-label', 'Show password');
        }
    }
</script>
@endsection