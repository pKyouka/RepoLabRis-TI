@extends('layouts.app', ['title' => 'Login Admin'])

@section('content')
    <div class="card" style="max-width: 520px; margin: 0 auto;">
        <h1>Login Admin</h1>
        <p class="muted">Akses dashboard dan data internal LAB hanya untuk akun admin.</p>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="field">
                <label for="email">Email Admin</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="field">
                <label class="row" style="gap: 0.5rem;">
                    <input type="checkbox" name="remember" value="1" style="width:auto;">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Masuk Sebagai Admin</button>
        </form>
    </div>
@endsection
