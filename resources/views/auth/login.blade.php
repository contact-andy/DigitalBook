@extends('layouts.guest') @section('title', 'Login') @section('content')

<div class="auth-full-page d-flex">
    <div class="auth-form p-3">
        <div class="text-center">
            <a class="sidebar-brand" href="/">
                <i
                    class="h1"
                    data-lucide="book-open-text"
                    style="width: 50px; height: 50px"
                ></i>
                <span class="h1" style="color: black">{{
                    config("app.name")
                }}</span>
            </a>
            <p class="lead">Sign in to your account to continue</p>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <hr />
                </div>
                <div class="col-auto text-uppercase d-flex align-items-center">
                    -
                </div>
                <div class="col">
                    <hr />
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        class="form-control form-control-lg"
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                        autofocus
                    />
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        class="form-control form-control-lg"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    />
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-lg btn-primary" type="submit">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
