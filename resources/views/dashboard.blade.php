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
                            <h3 class="mb-2">$ 24.300</h3>
                            <p class="mb-2">Total Earnings</p>
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
                                    data-lucide="dollar-sign"
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
                            <p class="mb-2">Pending Orders</p>
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
                                    data-lucide="shopping-bag"
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
                            <h3 class="mb-2">$ 18.700</h3>
                            <p class="mb-2">Total Revenue</p>
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
                                    data-lucide="dollar-sign"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8 d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <a
                                href="#"
                                data-bs-toggle="dropdown"
                                data-bs-display="static"
                            >
                                <i
                                    class="align-middle"
                                    data-lucide="more-horizontal"
                                ></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#"
                                    >Another action</a
                                >
                                <a class="dropdown-item" href="#"
                                    >Something else here</a
                                >
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Sales / Revenue</h5>
                </div>
                <div class="card-body d-flex w-100">
                    <div class="align-self-center chart chart-lg">
                        <canvas id="chartjs-dashboard-bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <span class="badge bg-info float-end">Today</span>
                    <h5 class="card-title mb-0">Daily feed</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <img
                            src="img/avatars/avatar-5.jpg"
                            width="36"
                            height="36"
                            class="rounded-circle me-2"
                            alt="Ashley Briggs"
                        />
                        <div class="flex-grow-1">
                            <small class="float-end">5m ago</small>
                            <strong>Ashley Briggs</strong> started following
                            <strong>Stacie Hall</strong><br />
                            <small class="text-muted">Today 7:51 pm</small
                            ><br />
                        </div>
                    </div>

                    <hr />
                    <div class="d-flex align-items-start">
                        <img
                            src="img/avatars/avatar.jpg"
                            width="36"
                            height="36"
                            class="rounded-circle me-2"
                            alt="Chris Wood"
                        />
                        <div class="flex-grow-1">
                            <small class="float-end">30m ago</small>
                            <strong>Chris Wood</strong> posted something on
                            <strong>Stacie Hall</strong>'s timeline<br />
                            <small class="text-muted">Today 7:21 pm</small>

                            <div class="border text-sm text-muted p-2 mt-1">
                                Etiam rhoncus. Maecenas tempus, tellus eget
                                condimentum rhoncus, sem quam semper libero, sit
                                amet adipiscing...
                            </div>
                        </div>
                    </div>

                    <hr />
                    <div class="d-flex align-items-start">
                        <img
                            src="img/avatars/avatar-4.jpg"
                            width="36"
                            height="36"
                            class="rounded-circle me-2"
                            alt="Stacie Hall"
                        />
                        <div class="flex-grow-1">
                            <small class="float-end">1h ago</small>
                            <strong>Stacie Hall</strong> posted a new blog<br />

                            <small class="text-muted">Today 6:35 pm</small>
                        </div>
                    </div>

                    <hr />
                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">Load more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6 col-xl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <a
                                href="#"
                                data-bs-toggle="dropdown"
                                data-bs-display="static"
                            >
                                <i
                                    class="align-middle"
                                    data-lucide="more-horizontal"
                                ></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#"
                                    >Another action</a
                                >
                                <a class="dropdown-item" href="#"
                                    >Something else here</a
                                >
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Calendar</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="chart">
                            <div id="calendar-dashboard"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 d-none d-xl-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <a
                                href="#"
                                data-bs-toggle="dropdown"
                                data-bs-display="static"
                            >
                                <i
                                    class="align-middle"
                                    data-lucide="more-horizontal"
                                ></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#"
                                    >Another action</a
                                >
                                <a class="dropdown-item" href="#"
                                    >Something else here</a
                                >
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Weekly sales</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="py-3">
                            <div class="chart chart-xs">
                                <canvas id="chartjs-dashboard-pie"></canvas>
                            </div>
                        </div>

                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th class="text-end">Revenue</th>
                                    <th class="text-end">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <i
                                            class="fas fa-square-full text-primary"
                                        ></i>
                                        Direct
                                    </td>
                                    <td class="text-end">$ 2602</td>
                                    <td class="text-end text-success">+43%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i
                                            class="fas fa-square-full text-warning"
                                        ></i>
                                        Affiliate
                                    </td>
                                    <td class="text-end">$ 1253</td>
                                    <td class="text-end text-success">+13%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i
                                            class="fas fa-square-full text-danger"
                                        ></i>
                                        E-mail
                                    </td>
                                    <td class="text-end">$ 541</td>
                                    <td class="text-end text-success">+24%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i
                                            class="fas fa-square-full text-dark"
                                        ></i>
                                        Other
                                    </td>
                                    <td class="text-end">$ 1465</td>
                                    <td class="text-end text-success">+11%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-4 d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <div class="card-actions float-end">
                        <div class="dropdown position-relative">
                            <a
                                href="#"
                                data-bs-toggle="dropdown"
                                data-bs-display="static"
                            >
                                <i
                                    class="align-middle"
                                    data-lucide="more-horizontal"
                                ></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#"
                                    >Another action</a
                                >
                                <a class="dropdown-item" href="#"
                                    >Something else here</a
                                >
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-0">Appointments</h5>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <strong>Chat with Carl and Ashley</strong>
                            <span class="float-end text-muted text-sm"
                                >30m ago</span
                            >
                            <p>
                                Nam pretium turpis et arcu. Duis arcu tortor,
                                suscipit eget, imperdiet nec, imperdiet iaculis,
                                ipsum. Sed aliquam ultrices mauris...
                            </p>
                        </li>
                        <li class="timeline-item">
                            <strong>The big launch</strong>
                            <span class="float-end text-muted text-sm"
                                >2h ago</span
                            >
                            <p>
                                Sed aliquam ultrices mauris. Integer ante arcu,
                                accumsan a, consectetuer eget, posuere ut,
                                mauris. Praesent adipiscing. Phasellus
                                ullamcorper ipsum rutrum nunc...
                            </p>
                        </li>
                        <li class="timeline-item">
                            <strong>Coffee break</strong>
                            <span class="float-end text-muted text-sm"
                                >3h ago</span
                            >
                            <p>
                                Curabitur ligula sapien, tincidunt non, euismod
                                vitae, posuere imperdiet, leo. Maecenas
                                malesuada...
                            </p>
                        </li>
                        <li class="timeline-item">
                            <strong>Chat with team</strong>
                            <span class="float-end text-muted text-sm"
                                >30m ago</span
                            >
                            <p>
                                Nam pretium turpis et arcu. Duis arcu tortor,
                                suscipit eget, imperdiet nec, imperdiet iaculis,
                                ipsum...
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card flex-fill">
        <div class="card-header">
            <div class="card-actions float-end">
                <div class="dropdown position-relative">
                    <a
                        href="#"
                        data-bs-toggle="dropdown"
                        data-bs-display="static"
                    >
                        <i
                            class="align-middle"
                            data-lucide="more-horizontal"
                        ></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#"
                            >Something else here</a
                        >
                    </div>
                </div>
            </div>
            <h5 class="card-title mb-0">Latest Projects</h5>
        </div>
        <table class="table table-borderless my-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="d-none d-xxl-table-cell">Company</th>
                    <th class="d-none d-xl-table-cell">Author</th>
                    <th>Status</th>
                    <th class="d-none d-xl-table-cell text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-body-tertiary rounded-2">
                                    <img
                                        class="p-2"
                                        src="img/brands/brand-1.svg"
                                    />
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <strong>Project Apollo</strong>
                                <div class="text-muted">Web, UI/UX Design</div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xxl-table-cell">
                        <strong>Gantos</strong>
                        <div class="text-muted">Real Estate</div>
                    </td>
                    <td class="d-none d-xl-table-cell">
                        <strong>Carl Jenkins</strong>
                        <div class="text-muted">HTML, JS, React</div>
                    </td>
                    <td>
                        <div class="d-flex flex-column w-100">
                            <span class="me-2 mb-1 text-muted">65%</span>
                            <div class="progress progress-sm w-100">
                                <div
                                    class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: 65%"
                                ></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xl-table-cell text-end">
                        <a href="#" class="btn btn-light">View</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-body-tertiary rounded-2">
                                    <img
                                        class="p-2"
                                        src="img/brands/brand-2.svg"
                                    />
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <strong>Project Bongo</strong>
                                <div class="text-muted">Web</div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xxl-table-cell">
                        <strong>Adray Transportation</strong>
                        <div class="text-muted">Transportation</div>
                    </td>
                    <td class="d-none d-xl-table-cell">
                        <strong>Bertha Martin</strong>
                        <div class="text-muted">HTML, JS, Vue</div>
                    </td>
                    <td>
                        <div class="d-flex flex-column w-100">
                            <span class="me-2 mb-1 text-muted">33%</span>
                            <div class="progress progress-sm w-100">
                                <div
                                    class="progress-bar bg-danger"
                                    role="progressbar"
                                    style="width: 33%"
                                ></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xl-table-cell text-end">
                        <a href="#" class="btn btn-light">View</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-body-tertiary rounded-2">
                                    <img
                                        class="p-2"
                                        src="img/brands/brand-3.svg"
                                    />
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <strong>Project Canary</strong>
                                <div class="text-muted">Web, UI/UX Design</div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xxl-table-cell">
                        <strong>Evans</strong>
                        <div class="text-muted">Insurance</div>
                    </td>
                    <td class="d-none d-xl-table-cell">
                        <strong>Stacie Hall</strong>
                        <div class="text-muted">HTML, JS, Laravel</div>
                    </td>
                    <td>
                        <div class="d-flex flex-column w-100">
                            <span class="me-2 mb-1 text-muted">50%</span>
                            <div class="progress progress-sm w-100">
                                <div
                                    class="progress-bar bg-warning"
                                    role="progressbar"
                                    style="width: 50%"
                                ></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xl-table-cell text-end">
                        <a href="#" class="btn btn-light">View</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-body-tertiary rounded-2">
                                    <img
                                        class="p-2"
                                        src="img/brands/brand-4.svg"
                                    />
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <strong>Project Edison</strong>
                                <div class="text-muted">UI/UX Design</div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xxl-table-cell">
                        <strong>Monsource Investment Group</strong>
                        <div class="text-muted">Finance</div>
                    </td>
                    <td class="d-none d-xl-table-cell">
                        <strong>Carl Jenkins</strong>
                        <div class="text-muted">HTML, JS, React</div>
                    </td>
                    <td>
                        <div class="d-flex flex-column w-100">
                            <span class="me-2 mb-1 text-muted">80%</span>
                            <div class="progress progress-sm w-100">
                                <div
                                    class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: 80%"
                                ></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xl-table-cell text-end">
                        <a href="#" class="btn btn-light">View</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-body-tertiary rounded-2">
                                    <img
                                        class="p-2"
                                        src="img/brands/brand-5.svg"
                                    />
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <strong>Project Indigo</strong>
                                <div class="text-muted">Web, UI/UX Design</div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xxl-table-cell">
                        <strong>Edwards</strong>
                        <div class="text-muted">Retail</div>
                    </td>
                    <td class="d-none d-xl-table-cell">
                        <strong>Ashley Briggs</strong>
                        <div class="text-muted">HTML, JS, Vue</div>
                    </td>
                    <td>
                        <div class="d-flex flex-column w-100">
                            <span class="me-2 mb-1 text-muted">78%</span>
                            <div class="progress progress-sm w-100">
                                <div
                                    class="progress-bar bg-primary"
                                    role="progressbar"
                                    style="width: 78%"
                                ></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-xl-table-cell text-end">
                        <a href="#" class="btn btn-light">View</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
