<nav class="navbar navbar-expand navbar-bg">
    <a class="sidebar-toggle">
    <i class="hamburger align-self-center"></i>
    </a>

    <form class="d-none d-sm-inline-block">
    <div class="input-group input-group-navbar">
        <input
        type="text"
        class="form-control"
        placeholder="Search communication"
        aria-label="Search"
        />
        <button class="btn" type="button">
        <i class="align-middle" data-lucide="search"></i>
        </button>
    </div>
    </form>

    

    <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
        {{-- <li class="nav-item dropdown">
        <a
            class="nav-icon dropdown-toggle"
            href="#"
            id="messagesDropdown"
            data-bs-toggle="dropdown"
        >
            <div class="position-relative">
            <i
                class="align-middle text-body"
                data-lucide="message-circle"
            ></i>
            <span class="indicator">4</span>
            </div>
        </a>
        <div
            class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
            aria-labelledby="messagesDropdown"
        >
            <div class="dropdown-menu-header">
            <div class="position-relative">4 New Messages</div>
            </div>
            <div class="list-group">
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <img
                    src="img/avatars/avatar-5.jpg"
                    class="img-fluid rounded-circle"
                    alt="Ashley Briggs"
                    width="40"
                    height="40"
                    />
                </div>
                <div class="col-10 ps-2">
                    <div>Ashley Briggs</div>
                    <div class="text-muted small mt-1">
                    Nam pretium turpis et arcu. Duis arcu tortor.
                    </div>
                    <div class="text-muted small mt-1">15m ago</div>
                </div>
                </div>
            </a>
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <img
                    src="img/avatars/avatar-2.jpg"
                    class="img-fluid rounded-circle"
                    alt="Carl Jenkins"
                    width="40"
                    height="40"
                    />
                </div>
                <div class="col-10 ps-2">
                    <div>Carl Jenkins</div>
                    <div class="text-muted small mt-1">
                    Curabitur ligula sapien euismod vitae.
                    </div>
                    <div class="text-muted small mt-1">2h ago</div>
                </div>
                </div>
            </a>
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <img
                    src="img/avatars/avatar-4.jpg"
                    class="img-fluid rounded-circle"
                    alt="Stacie Hall"
                    width="40"
                    height="40"
                    />
                </div>
                <div class="col-10 ps-2">
                    <div>Stacie Hall</div>
                    <div class="text-muted small mt-1">
                    Pellentesque auctor neque nec urna.
                    </div>
                    <div class="text-muted small mt-1">4h ago</div>
                </div>
                </div>
            </a>
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <img
                    src="img/avatars/avatar-3.jpg"
                    class="img-fluid rounded-circle"
                    alt="Bertha Martin"
                    width="40"
                    height="40"
                    />
                </div>
                <div class="col-10 ps-2">
                    <div>Bertha Martin</div>
                    <div class="text-muted small mt-1">
                    Aenean tellus metus, bibendum sed, posuere ac,
                    mattis non.
                    </div>
                    <div class="text-muted small mt-1">5h ago</div>
                </div>
                </div>
            </a>
            </div>
            <div class="dropdown-menu-footer">
            <a href="#" class="text-muted">Show all messages</a>
            </div>
        </div>
        </li> --}}
        {{-- <li class="nav-item dropdown">
        <a
            class="nav-icon dropdown-toggle"
            href="#"
            id="alertsDropdown"
            data-bs-toggle="dropdown"
        >
            <div class="position-relative">
            <i
                class="align-middle text-body"
                data-lucide="bell-off"
            ></i>
            </div>
        </a>
        <div
            class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
            aria-labelledby="alertsDropdown"
        >
            <div class="dropdown-menu-header">4 New Notifications</div>
            <div class="list-group">
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <i class="text-danger" data-lucide="alert-circle"></i>
                </div>
                <div class="col-10">
                    <div>Update completed</div>
                    <div class="text-muted small mt-1">
                    Restart server 12 to complete the update.
                    </div>
                    <div class="text-muted small mt-1">2h ago</div>
                </div>
                </div>
            </a>
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <i class="text-warning" data-lucide="bell"></i>
                </div>
                <div class="col-10">
                    <div>Lorem ipsum</div>
                    <div class="text-muted small mt-1">
                    Aliquam ex eros, imperdiet vulputate hendrerit et.
                    </div>
                    <div class="text-muted small mt-1">6h ago</div>
                </div>
                </div>
            </a>
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <i class="text-primary" data-lucide="home"></i>
                </div>
                <div class="col-10">
                    <div>Login from 192.186.1.1</div>
                    <div class="text-muted small mt-1">8h ago</div>
                </div>
                </div>
            </a>
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                <div class="col-2">
                    <i class="text-success" data-lucide="user-plus"></i>
                </div>
                <div class="col-10">
                    <div>New connection</div>
                    <div class="text-muted small mt-1">
                    Anna accepted your request.
                    </div>
                    <div class="text-muted small mt-1">12h ago</div>
                </div>
                </div>
            </a>
            </div>
            <div class="dropdown-menu-footer">
            <a href="#" class="text-muted">Show all notifications</a>
            </div>
        </div>
        </li> --}}
        <!-- <li class="nav-item nav-theme-toggle dropdown">
        <a class="nav-icon js-theme-toggle" href="#">
            <div class="position-relative">
            <i
                class="align-middle text-body nav-theme-toggle-light"
                data-lucide="sun"
            ></i>
            <i
                class="align-middle text-body nav-theme-toggle-dark"
                data-lucide="moon"
            ></i>
            </div>
        </a>
        </li> -->
        <!-- <li class="nav-item dropdown">
        <a
            class="nav-flag dropdown-toggle"
            href="#"
            id="languageDropdown"
            data-bs-toggle="dropdown"
        >
            <img src="img/flags/us.png" alt="English" />
        </a>
        <div
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="languageDropdown"
        >
            <a class="dropdown-item" href="#">
            <img
                src="img/flags/us.png"
                alt="English"
                width="20"
                class="align-middle me-1"
            />
            <span class="align-middle">English</span>
            </a>
            <a class="dropdown-item" href="#">
            <img
                src="img/flags/es.png"
                alt="Spanish"
                width="20"
                class="align-middle me-1"
            />
            <span class="align-middle">Spanish</span>
            </a>
            <a class="dropdown-item" href="#">
            <img
                src="img/flags/de.png"
                alt="German"
                    width="20"
                class="align-middle me-1"
            />
            <span class="align-middle">German</span>
            </a>
            <a class="dropdown-item" href="#">
            <img
                src="img/flags/nl.png"
                alt="Dutch"
                width="20"
                class="align-middle me-1"
            />
            <span class="align-middle">Dutch</span>
            </a>
        </div>
        </li> -->
        <li class="nav-item dropdown">
        <a
            class="nav-icon dropdown-toggle d-inline-block d-sm-none"
            href="#"
            data-bs-toggle="dropdown"
        >
            <i class="align-middle" data-lucide="settings"></i>
        </a>

        <a
            class="nav-link dropdown-toggle d-none d-sm-inline-block"
            href="#"
            data-bs-toggle="dropdown"
        >
            <img
            src = "{{ URL::asset('build/assets/images/avatar.jpg'); }}"
            class="img-fluid rounded-circle me-1 mt-n2 mb-n2"
            alt="Chris Wood"
            width="40"
            height="40"
            />
            <span>{{ Auth::user()->userId }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="{{ route('profile.edit') }}"
            ><i class="align-middle me-1" data-lucide="user"></i>
            
            Profile</a
            >
            {{-- <a class="dropdown-item" href="#"
            ><i class="align-middle me-1" data-lucide="pie-chart"></i>
            Analytics</a
            > --}}
            <div class="dropdown-divider"></div>
            {{-- <a class="dropdown-item" href="/pages-settings"
            >Settings & Privacy</a
            >
            <a class="dropdown-item" href="#">Help</a> --}}
            
                <form method="POST" action="{{ route('logout') }}">
                            @csrf
                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <i class="align-middle me-1" data-lucide="log-out"></i>
                                Sign out</a>
                        </form>
                
               
        </div>
        </li>
    </ul>
 </div>
</nav>