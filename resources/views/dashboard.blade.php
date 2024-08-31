@extends('layouts.app') @section('title', 'Home') @section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3>{{ config("app.name") }} Dashboard</h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            <div class="dropdown me-2 d-inline-block position-relative">
                <a
                    class="btn btn-light bg-white shadow-sm dropdown-toggle"
                    href="#"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                >
                    <i class="align-middle mt-n1" data-lucide="calendar"></i>
                    Today
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Settings</h6>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>

            <button class="btn btn-primary shadow-sm">
                <i class="align-middle" data-lucide="filter">&nbsp;</i>
            </button>
            <button class="btn btn-primary shadow-sm">
                <i class="align-middle" data-lucide="refresh-cw">&nbsp;</i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card illustration flex-fill">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">
                                    Welcome Back, {{ Auth::user()->name }}!
                                </h4>
                                <p class="mb-0">DigitalBook Dashboard</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img
                                src="{{ URL::asset('build/assets/images/customer-support.png'); }}"
                                alt="Customer Support"
                                class="img-fluid illustration-img"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">24</h3>
                            <p class="mb-2">Message Templates</p>
                            <div class="mb-0">
                                <span class="badge badge-subtle-success me-2">
                                    +5.35%
                                </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i
                                    class="align-middle text-success"
                                    data-lucide="message-square-more"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">43</h3>
                            <p class="mb-2">Calendar Events</p>
                            <div class="mb-0">
                                <span class="badge badge-subtle-danger me-2">
                                    -4.25%
                                </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i
                                    class="align-middle text-danger"
                                    data-lucide="calendar-days"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">18</h3>
                            <p class="mb-2">Survey Published</p>
                            <div class="mb-0">
                                <span class="badge badge-subtle-success me-2">
                                    +8.65%
                                </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i
                                    class="align-middle text-info"
                                    data-lucide="vote"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
