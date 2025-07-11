@php
    $user = Auth::guard('web')->user();
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.home.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- Full Logo (when expanded) -->
                <img src="{{ asset('backend/assets/img/uttara_logo_bgwhite.png') }}"
                    alt="Uttara Motors Full Logo"
                    class="logo-expanded"
                    style="height: 100px; width: auto;">

                <!-- Icon Only (when collapsed) -->
                <img src="{{ asset('backend/assets/img/favicon/uttaraIcon.png') }}"
                    alt="Uttara Motors Icon"
                    class="logo-collapsed"
                    style="height: 40px; width: 40px;">
            </span>
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
            <a href="{{ route('dashboard.home.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
        </li>
        <li class="menu-item @yield('invoice')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-files"></i>
                <div data-i18n="Invoice">Invoice</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @yield('import_invoice')">
                    <a href="{{ route('dashboard.invoice.import_index') }}" class="menu-link">
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

        <li class="menu-item @yield('dealer')">
            <a href="{{ route('dashboard.dealer.index') }}" class="menu-link">
                <i class=" menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Dealers">Dealers</div>
            </a>
        </li>

        <div style="margin: 15px 0;height: 3px;background: #988ff4;width: 100%;"></div>

        <li class="menu-item @yield('settings')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
            <ul class="menu-sub">
                @if ($user->can('user.manage'))
                    <li class="menu-item @yield('user')">
                        <a href="{{ route('dashboard.user.index') }}" class="menu-link">
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
                @endif
                <li class="menu-item @yield('app_setup')">
                    <a href="" class="menu-link">
                        <div data-i18n="Website Setting">App Setup</div>
                    </a>
                </li>
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
