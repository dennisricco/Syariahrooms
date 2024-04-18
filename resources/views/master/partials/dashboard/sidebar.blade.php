<ul>
    <li>
        <div class="menu-title">MAIN</div>
        <ul>
            <li>
                <a href="{{ route('dashboard.index') }}"
                    class="{{ \App\Helper\Url::url(route('dashboard.index')) ? 'active' : '' }}">
                    <div class="tooltip-item in-active" data-bs-toggle="tooltip" data-bs-placement="right" title=""
                        data-bs-original-title="Dashboard" aria-label="Dashboard"></div>
                    <span>
                        <i class="iconly-Curved-Home"></i>
                        <span>Dashboard</span>
                    </span>
                </a>
            </li>
            @can('transaction-index')
                <li>
                    <a href="{{ route('dashboard.transaction.index') }}"
                        class="{{ \App\Helper\Url::url(route('dashboard.transaction.index')) ? 'active' : '' }}">
                        <div class="tooltip-item in-active" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="" data-bs-original-title="Transaksi" aria-label="Transaksi"></div>
                        <span>
                            <i class="iconly-Light-Paper"></i>
                            <span>Histori Transaksi</span>
                        </span>
                    </a>
                </li>
            @endcan
            <li>
                <div class="menu-title">Setting</div>
                <ul>
                    @can('user-index')
                        <li>
                            <a href="{{ route('dashboard.user.index') }}"
                                class="{{ \App\Helper\Url::url(route('dashboard.user.index')) ? 'active' : '' }}">
                                <div class="tooltip-item in-active" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="" data-bs-original-title="User" aria-label="User"></div>
                                <span>
                                    <i class="iconly-Curved-People"></i>
                                    <span>User</span>
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('membership-index')
                        <li>
                            <a href="{{ route('dashboard.membership.index') }}"
                                class="{{ \App\Helper\Url::url(route('dashboard.membership.index')) ? 'active' : '' }}">
                                <div class="tooltip-item in-active" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="" data-bs-original-title="Membership" aria-label="Membership"></div>
                                <span>
                                    <i class="iconly-Light-Category"></i>
                                    <span>Membership</span>
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('role-index')
                        <li>
                            <a href="{{ route('dashboard.role.index') }}"
                                class="{{ \App\Helper\Url::url(route('dashboard.role.index')) ? 'active' : '' }}">
                                <div class="tooltip-item in-active" data-bs-toggle="tooltip" data-bs-placement="right"
                                    title="" data-bs-original-title="Role & Permission"
                                    aria-label="Role & Permission"></div>
                                <span>
                                    <i class="iconly-Light-Lock"></i>
                                    <span>Role & Permission</span>
                                </span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        </ul>
