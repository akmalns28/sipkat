<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <h3 class="text-center menu-text fw-bolder ms-2">SIPKAT</h3>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                @if (Request::is('dashboard*'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem" class="menu-icon flex-shrink"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M4 20h12v2H4c-1.1 0-2-.9-2-2V7h2m18-3v12c0 1.1-.9 2-2 2H8c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2M12 8h-2v6h2m3-8h-2v8h2m3-3h-2v3h2Z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem" class="menu-icon flex-shrink"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M20 16V4H8v12m14 0c0 1.1-.9 2-2 2H8c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2m-6 16v2H4c-1.1 0-2-.9-2-2V7h2v13m12-9h2v3h-2m-3-8h2v8h-2m-3-6h2v6h-2Z" />
                    </svg>
                @endif
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Layanan</span>
        </li>
        @if (Auth::user()->role == 'super admin')

            <li class="menu-item {{ str_contains(Route::current()->getName(), 'sumur-pantau') ? 'active' : '' }}">
                <a href="{{ route('sumur-pantau.index') }}" class="menu-link">
                    @if (Request::is('sumur*'))
                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem"
                            class="menu-icon flex-shrink" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 20a6 6 0 0 1-6-6c0-4 6-10.75 6-10.75S18 10 18 14a6 6 0 0 1-6 6" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem"
                            class="menu-icon flex-shrink" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m12 3.77l-.75.84S9.97 6.06 8.68 7.94S6 12.07 6 14.23a6 6 0 0 0 6 6a6 6 0 0 0 6-6c0-2.16-1.39-4.41-2.68-6.29s-2.57-3.33-2.57-3.33zm0 3.13c.44.52.84.95 1.68 2.17c1.21 1.76 2.32 4 2.32 5.16c0 2.22-1.78 4-4 4s-4-1.78-4-4c0-1.16 1.11-3.4 2.32-5.16c.84-1.22 1.24-1.65 1.68-2.17" />
                        </svg>
                    @endif
                    <div data-i18n="Analytics">Sumur Pantau</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role != 'kepala bidang')
            @if (Request::is('monitoring*'))
                <li class="menu-item {{ str_contains(Route::current()->getName(), 'monitoring') ? 'active' : '' }}">
                    <a href="{{ route('monitoring.index') }}" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem"
                            class="menu-icon flex-shrink" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M4.616 19q-.691 0-1.153-.462T3 17.384V12.5h4.683l1.86 3.72q.067.14.192.21t.265.07t.266-.07t.192-.21L14 9.134l1.542 3.084q.067.14.192.21T16 12.5h5v4.885q0 .69-.462 1.152T19.385 19zM3 11.5V6.616q0-.691.463-1.153T4.615 5h14.77q.69 0 1.152.463T21 6.616V11.5h-4.683l-1.86-3.72q-.066-.12-.182-.175T14 7.55q-.14 0-.265.055t-.193.176L10 14.866L8.458 11.78q-.067-.14-.192-.21T8 11.5z" />
                        </svg>
                        <div data-i18n="Analytics">Monitoring</div>
                    </a>
                </li>
            @else
                <li class="menu-item {{ str_contains(Route::current()->getName(), 'monitoring') ? 'active' : '' }}">
                    <a href="{{ route('monitoring.index') }}" class="menu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem"
                            class="menu-icon flex-shrink" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M3 9.5V6.616q0-.691.463-1.153T4.615 5h14.77q.69 0 1.152.463T21 6.616V9.5h-1V6.616q0-.231-.192-.424T19.385 6H4.615q-.23 0-.423.192T4 6.616V9.5zM4.616 19q-.691 0-1.153-.462T3 17.384V14.5h1v2.885q0 .23.192.423t.423.192h14.77q.23 0 .423-.192t.192-.424V14.5h1v2.885q0 .69-.462 1.152T19.385 19zM10 16.5q.14 0 .266-.07t.192-.21L14 9.134l1.542 3.084q.067.14.192.21T16 12.5h5v-1h-4.683l-1.86-3.72q-.066-.12-.182-.175T14 7.55q-.14 0-.265.055t-.193.176L10 14.866L8.458 11.78q-.067-.14-.192-.21T8 11.5H3v1h4.683l1.86 3.72q.067.14.192.21t.265.07m2-4.5" />
                        </svg>
                        <div data-i18n="Analytics">Monitoring</div>
                    </a>
                </li>
            @endif
        @endif

        <li class="menu-item {{ str_contains(Route::current()->getName(), 'laporan') ? 'active' : '' }}">
            <a href="{{ route('laporan.index') }}" class="menu-link">
                @if (Request::is('laporan*'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem" class="menu-icon flex-shrink"
                        width="24" height="24" viewBox="0 0 16 16">
                        <path fill="currentColor"
                            d="M9.5 5h3.25L9 1.25V4.5a.5.5 0 0 0 .5.5m0 1A1.5 1.5 0 0 1 8 4.5V1H4.5A1.5 1.5 0 0 0 3 2.5v11A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V6zM6 12.5a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 1 0zm2.5 0a.5.5 0 0 1-1 0v-2a.5.5 0 0 1 1 0zm2.5 0a.5.5 0 0 1-1 0v-4a.5.5 0 0 1 1 0z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem" class="menu-icon flex-shrink"
                        width="24" height="24" viewBox="0 0 16 16">
                        <path fill="currentColor"
                            d="M5.5 13a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 0 .5.5m5.5-.5a.5.5 0 0 1-1 0v-4a.5.5 0 0 1 1 0zm-3.06.5a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-1 0v2a.5.5 0 0 0 .5.5M3 3a2 2 0 0 1 2-2h3.586a1.5 1.5 0 0 1 1.061.439l2.914 2.914c.281.282.439.663.439 1.061V13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V6H9.5A1.5 1.5 0 0 1 8 4.5V2zm4.5 3h2.293L9 2.207V4.5a.5.5 0 0 0 .5.5" />
                    </svg>
                @endif
                <div data-i18n="Analytics">Laporan</div>
            </a>
        </li>
        @if (Auth::user()->role == 'super admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">User</span>
            </li>
            <li class="menu-item {{ str_contains(Route::current()->getName(), 'user') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon flex-shrink" width="24" height="24"
                        style="margin-right: 0.5rem" viewBox="0 0 24 24">
                        <g fill="{{ Request::is('user') ? 'currentColor' : 'none' }}" stroke="currentColor"
                            stroke-width="1.5">
                            <circle cx="12" cy="6" r="4" />
                            <path d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5Z" />
                        </g>
                    </svg>
                    <div data-i18n="Analytics">User</div>
                </a>
            </li>
        @endif

    </ul>
</aside>
