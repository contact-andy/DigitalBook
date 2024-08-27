<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <i data-lucide="book-open-text" style="font-size: 50px"></i>
            <span class="align-middle me-3">{{ config("app.name") }}</span>
        </a>

        <ul class="sidebar-nav">
            {{--
            <li class="sidebar-header">Navigation</li>
            --}}
            <li class="sidebar-item">
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <i class="align-middle" data-lucide="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                    {{-- <span class="badge badge-sidebar-primary">5</span> --}}
                </a>
            </li>
            {{--
            <li class="sidebar-header">Apps</li>
            --}}
            <!-- add 'active' class attribute value -->
            <li class="sidebar-item active">
                <a
                    data-bs-target="#messages"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i
                        class="align-middle"
                        data-lucide="message-square-more"
                    ></i>
                    <span class="align-middle">Messages</span>
                </a>
                <!-- add 'show' class attribute value-->
                <ul
                    id="messages"
                    class="sidebar-dropdown list-unstyled collapse show"
                    data-bs-parent="#sidebar"
                >
                    <!-- add 'active' class attribute value -->
                    <li class="sidebar-item">
                        <a
                            class="sidebar-link"
                            href="{{ route('message-categories.index') }}"
                        >
                            <!-- <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i> -->
                            Message Category
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a
                            class="sidebar-link"
                            href="{{ route('message-templates.index') }}"
                        >
                            <!-- <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i> -->
                            Message Templates
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ecommerce-customers">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Publish Messages
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ecommerce-invoice"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Response Message Templates</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ecommerce-pricing"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Automatic Message Templates</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ecommerce-pricing">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Message Approval</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ecommerce-pricing">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Message Response from the System</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#calendar"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="calendar-days"></i>
                    <span class="align-middle">Academic Calendar</span>
                </a>
                <ul
                    id="calendar"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-overview">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Calendar Manager</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Event Manager</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#polls"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="vote"></i>
                    <span class="align-middle">Poll Manager</span>
                </a>
                <ul
                    id="polls"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-overview">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Create a Poll</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Manage Polls</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#permission"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="shield-ellipsis"></i>
                    <span class="align-middle">Application Permission</span>
                </a>
                <ul
                    id="permission"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-overview">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Send a Message</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Approve a Message</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Manage Message Templates</a
                        >
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a
                    data-bs-target="#report"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="proportions"></i>
                    <span class="align-middle">Report and Analysis</span>
                </a>
                <ul
                    id="report"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-overview">
                            <i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Analytical Report</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Messages Report</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Responses Report</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Draft Messages</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Scheduled Messages</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/projects-details"
                            ><i
                                class="align-middle"
                                data-lucide="chevron-last"
                            ></i>
                            Survey Responses</a
                        >
                    </li>
                </ul>
            </li>

            {{--
            <li class="sidebar-item">
                <a class="sidebar-link" href="/chat">
                    <i class="align-middle" data-lucide="list"></i>
                    <span class="align-middle">Chat</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/file-manager">
                    <i class="align-middle" data-lucide="files"></i>
                    <span class="align-middle">File Manager</span>
                    <span class="badge badge-sidebar-primary">New</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/calendar">
                    <i class="align-middle" data-lucide="calendar"></i>
                    <span class="align-middle">Calendar</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#email"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="mail"></i>
                    <span class="align-middle">Email</span>
                    <span class="badge badge-sidebar-primary">New</span>
                </a>
                <ul
                    id="email"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/email-inbox">Inbox</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/email-details"
                            >Details</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#tasks"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="trello"></i>
                    <span class="align-middle">Tasks</span>
                </a>
                <ul
                    id="tasks"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/tasks-list">
                            List
                            <span class="badge badge-sidebar-primary">New</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/tasks-kanban">Kanban</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-header">Pages</li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#pages"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="layout"></i>
                    <span class="align-middle">Pages</span>
                </a>
                <ul
                    id="pages"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/pages-profile"
                            >Profile</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/pages-settings"
                            >Settings</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/pages-blank"
                            >Blank Page</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#auth"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="users"></i>
                    <span class="align-middle">Auth</span>
                    <span class="badge badge-sidebar-secondary">Special</span>
                </a>
                <ul
                    id="auth"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-sign-in">Sign In</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-sign-in-cover"
                            >Sign In Cover</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-sign-up">Sign Up</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-sign-up-cover"
                            >Sign Up Cover</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-reset-password"
                            >Reset Password</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a
                            class="sidebar-link"
                            href="/auth-reset-password-cover"
                            >Reset Password Cover</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-lock-screen"
                            >Lock Screen</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-lock-screen-cover"
                            >Lock Screen Cover</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-2fa">2FA</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-2fa-cover"
                            >2FA Cover</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-404">404 Page</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/auth-500">500 Page</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/landing" target="_blank">
                    <i class="align-middle" data-lucide="layout-template"></i>
                    <span class="align-middle">Landing</span>
                    <span class="badge badge-sidebar-primary">New</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#docs"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="book-open"></i>
                    <span class="align-middle">Documentation</span>
                </a>
                <ul
                    id="docs"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/docs-introduction"
                            >Introduction</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/docs-installation"
                            >Getting Started</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/docs-customization"
                            >Customization</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/docs-plugins">Plugins</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/docs-changelog"
                            >Changelog</a
                        >
                    </li>
                </ul>
            </li>

            <li class="sidebar-header">Plugins & Addons</li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#forms-plugins"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="check-square"></i>
                    <span class="align-middle">Form Plugins</span>
                </a>
                <ul
                    id="forms-plugins"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-advanced-inputs"
                            >Advanced Inputs</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-editors"
                            >Editors</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-validation"
                            >Validation</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-wizard">Wizard</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#datatables"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="list"></i>
                    <span class="align-middle">DataTables</span>
                </a>
                <ul
                    id="datatables"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/datatables-responsive"
                            >Responsive Table</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/datatables-buttons"
                            >Table with Buttons</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/datatables-column-search"
                            >Column Search</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/datatables-fixed-header"
                            >Fixed Header</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/datatables-multi"
                            >Multi Selection</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/datatables-ajax"
                            >Ajax Sourced Data</a
                        >
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a
                    data-bs-target="#charts"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="pie-chart"></i>
                    <span class="align-middle">Charts</span>
                    <span class="badge badge-sidebar-primary">New</span>
                </a>
                <ul
                    id="charts"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/charts-chartjs"
                            >Chart.js</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/charts-apexcharts"
                            >ApexCharts
                            <span class="badge badge-sidebar-primary"
                                >New</span
                            ></a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/notifications">
                    <i class="align-middle" data-lucide="bell"></i>
                    <span class="align-middle">Notifications</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#maps"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="map-pin"></i>
                    <span class="align-middle">Maps</span>
                </a>
                <ul
                    id="maps"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/maps-google"
                            >Google Maps</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/maps-vector"
                            >Vector Maps</a
                        >
                    </li>
                </ul>
            </li>

            <li class="sidebar-header">Tools & Components</li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#ui"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="grid"></i>
                    <span class="align-middle">UI Elements</span>
                </a>
                <ul
                    id="ui"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-alerts">Alerts</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-buttons">Buttons</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-cards">Cards</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-carousel">Carousel</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-embed-video"
                            >Embed Video</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-general"
                            >General
                            <span class="badge badge-sidebar-primary"
                                >10+</span
                            ></a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-grid">Grid</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-modals">Modals</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-offcanvas"
                            >Offcanvas</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-placeholders"
                            >Placeholders</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-tabs">Tabs</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/ui-typography"
                            >Typography</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#icons"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="heart"></i>
                    <span class="align-middle">Icons</span>
                    <span class="badge badge-sidebar-primary">1500+</span>
                </a>
                <ul
                    id="icons"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/icons-lucide">Lucide</a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/icons-font-awesome"
                            >Font Awesome</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#forms"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="check-square"></i>
                    <span class="align-middle">Forms</span>
                </a>
                <ul
                    id="forms"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-layouts"
                            >Layouts</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-basic-inputs"
                            >Basic Inputs</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-input-groups"
                            >Input Groups</a
                        >
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/forms-floating-labels"
                            >Floating Labels</a
                        >
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/tables">
                    <i class="align-middle" data-lucide="list"></i>
                    <span class="align-middle">Tables</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a
                    data-bs-target="#multi"
                    data-bs-toggle="collapse"
                    class="sidebar-link collapsed"
                >
                    <i class="align-middle" data-lucide="share-2"></i>
                    <span class="align-middle">Multi Level</span>
                </a>
                <ul
                    id="multi"
                    class="sidebar-dropdown list-unstyled collapse"
                    data-bs-parent="#sidebar"
                >
                    <li class="sidebar-item">
                        <a
                            data-bs-target="#multi-2"
                            data-bs-toggle="collapse"
                            class="sidebar-link collapsed"
                        >
                            Two Levels
                        </a>
                        <ul
                            id="multi-2"
                            class="sidebar-dropdown list-unstyled collapse"
                        >
                            <li class="sidebar-item">
                                <a class="sidebar-link" data-bs-target="#"
                                    >Item 1</a
                                >
                                <a class="sidebar-link" data-bs-target="#"
                                    >Item 2</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a
                            data-bs-target="#multi-3"
                            data-bs-toggle="collapse"
                            class="sidebar-link collapsed"
                        >
                            Three Levels
                        </a>
                        <ul
                            id="multi-3"
                            class="sidebar-dropdown list-unstyled collapse"
                        >
                            <li class="sidebar-item">
                                <a
                                    data-bs-target="#multi-3-1"
                                    data-bs-toggle="collapse"
                                    class="sidebar-link collapsed"
                                >
                                    Item 1
                                </a>
                                <ul
                                    id="multi-3-1"
                                    class="sidebar-dropdown list-unstyled collapse"
                                >
                                    <li class="sidebar-item">
                                        <a
                                            class="sidebar-link"
                                            data-bs-target="#"
                                            >Item 1</a
                                        >
                                        <a
                                            class="sidebar-link"
                                            data-bs-target="#"
                                            >Item 2</a
                                        >
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" data-bs-target="#"
                                    >Item 2</a
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            --}}
        </ul>

        {{--
        <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2"
                    >Monthly Sales Report</strong
                >
                <div class="mb-3 text-sm">
                    Your monthly sales report is ready for download!
                </div>

                <div class="d-grid">
                    <a
                        href="https://themes.getbootstrap.com/product/appstack-responsive-admin-template/"
                        class="btn btn-primary"
                        target="_blank"
                        >Download</a
                    >
                </div>
            </div>
        </div>
        --}}
    </div>
</nav>
