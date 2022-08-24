<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Main</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="pcoded-micon"><i class="fa fa-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'plans') ? 'active' : '' }}">
                <a href="{{ route('admin.plans.index') }}">
                    <span class="pcoded-micon"><i class="fa fa-server"></i></span>
                    <span class="pcoded-mtext">Plans</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'users') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">
                    <span class="pcoded-micon"><i class="fa fa-users"></i></span>
                    <span class="pcoded-mtext">Users</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'withdrawals') ? 'active' : '' }}">
                <a href="{{ route('admin.withdrawals') }}">
                    <span class="pcoded-micon"><i class="fa fa-money"></i></span>
                    <span class="pcoded-mtext">Withdrawals</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'deposits') ? 'active' : '' }}">
                <a href="{{ route('admin.deposits') }}">
                    <span class="pcoded-micon"><i class="fa fa-line-chart"></i></span>
                    <span class="pcoded-mtext">Deposits</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'contacts') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts') }}">
                    <span class="pcoded-micon"><i class="fa fa-envelope"></i></span>
                    <span class="pcoded-mtext">Contact Messages</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel">System</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ (request()->segment(2) == 'admins') ? 'active' : '' }}">
                <a href="{{ route('admin.admins') }}">
                    <span class="pcoded-micon"><i class="fa fa-user-secret"></i></span>
                    <span class="pcoded-mtext">Admins</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'settings') ? 'active' : '' }}">
                <a href="{{ route('admin.settings') }}">
                    <span class="pcoded-micon"><i class="fa fa-gear"></i></span>
                    <span class="pcoded-mtext">Settings</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'cities') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="pcoded-micon"><i class="fa fa-navicon"></i></span>
                    <span class="pcoded-mtext">IPN Logs</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
