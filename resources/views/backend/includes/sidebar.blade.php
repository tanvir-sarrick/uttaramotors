@php
    $user = Auth::guard('web')->user();
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- <svg width="32" height="22" viewbox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0"></path>
                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616"></path>
                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0"></path>
                </svg> --}}
                <img src="{{ asset('backend/assets/img/uttara_logo_bgwhite.png') }}" alt=""
                    style="height: 85px;width: 140px;">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bold">Vuexy</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>



    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item @yield('home')">
            <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>

        <!-- Front Pages -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons ti ti-files'></i>
                <div data-i18n="Blogs">Blogs</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="../front-pages/landing-page.html" class="menu-link" target="_blank">
                        <div data-i18n="Manage Blog">Manage Blog</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../front-pages/pricing-page.html" class="menu-link" target="_blank">
                        <div data-i18n="Create Blog">Create Blog</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../front-pages/pricing-page.html" class="menu-link" target="_blank">
                        <div data-i18n="All Categories">All Categories</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../front-pages/pricing-page.html" class="menu-link" target="_blank">
                        <div data-i18n="All Sub Categories">All Sub Categories</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../front-pages/pricing-page.html" class="menu-link" target="_blank">
                        <div data-i18n="All Tags">All Tags</div>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Apps & Pages -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
        </li>
        <li class="menu-item @yield('active_open')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-files"></i>
                <div data-i18n="Invoice">Invoice</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @yield('import_invoice')">
                    <a href="{{ route('dashboard.invoice.import') }}" class="menu-link">
                        <div data-i18n="Import Invoice">Import Invoice</div>
                    </a>
                </li>
                {{-- @if ($user->can('invoice.manage')) --}}
                <li class="menu-item @yield('all_invoice')">
                    <a href="{{ route('dashboard.invoice.index') }}" class="menu-link">
                        <div data-i18n="All Invoices">All Invoices</div>
                    </a>
                </li>
                {{-- @endif --}}
            </ul>
        </li>
        {{-- <li class="menu-item @yield('invoice')">
            <a href="{{ route('dashboard.invoice.index') }}" class="menu-link">
                <i class=" menu-icon tf-icons ti ti-file-import"></i>
                <div data-i18n="Invoice Import"> Import Invoice</div>
            </a>
        </li> --}}
        <li class="menu-item @yield('dealer')">
            <a href="{{ route('dashboard.dealer.index') }}" class="menu-link">
                <i class=" menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Dealers">Dealers</div>
            </a>
        </li>

        <div style="margin-top: 50px;height: 3px;background: #988ff4;width: 100%;"></div>
        {{-- <li class="menu-item" @yield('settings')>
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
        </li> --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @yield('active_open')">
                    <a href="" class="menu-link">
                        <div data-i18n="Website Setting">Website Setting</div>
                    </a>
                </li>
                @if ($user->can('user.manage'))
                    <li class="menu-item @yield('user')">
                        <a href="{{ route('dashboard.user.index') }}" class="menu-link">
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @if ($user->can('permission.manage') || $user->can('role.manage'))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-adjustments-cog"></i>

                    <div data-i18n="Role & Permission">Role & Permission</div>
                </a>
                <ul class="menu-sub">
                    @if ($user->can('permission.manage'))
                        <li class="menu-item">
                            <a href="{{ route('dashboard.permission.index') }}" class="menu-link">
                                <div data-i18n="Manage Permission">Manage Permission</div>
                            </a>
                        </li>
                    @endif
                    @if ($user->can('role.manage'))
                        <li class="menu-item">
                            <a href="{{ route('dashboard.role.index') }}" class="menu-link">
                                <div data-i18n="Manage Role">Manage Role</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</aside>
