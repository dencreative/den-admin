<aside class="sidebar">
    <div class="scrollbar-inner">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <div class="user__name">{{ Auth::user()->name }}</div>
                {{--<div class="user__email">{{ Auth::user()->email }}</div>--}}
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="">View Profile</a>
                <a class="dropdown-item" href="">Settings</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
            </div>
        </div>

        <ul class="navigation">
            <li><a href="dashboard"><i class="zmdi zmdi-view-dashboard"></i>Dashboard</a></li>
            <hr>

            @can('view', App\User::class)
                <li><a href="users"><i class="zmdi zmdi-accounts-list"></i>Users</a></li>
            @endcan
            @can('view', App\Role::class)
                <li><a href="roles"><i class="zmdi zmdi-face"></i>Roles</a></li>
            @endcan
            @canany('view', [App\Role::class, App\User::class])
                <hr>
            @endcanany

            <li class="navigation__sub">
                <a href=""><i class="zmdi zmdi-collection-text"></i> Playbooks</a>
                <ul>
                    <li><a href="playbooks/entries">Entries</a></li>
                    <li><a href="playbooks/categories">Categories</a></li>
                </ul>
            </li>
            <hr>

            <li><a href=""><i class="zmdi zmdi-developer-board"></i>Tasks</a></li>
            <li><a href=""><i class="zmdi zmdi-calendar-alt"></i>Calendar</a></li>
            <li><a href=""><i class="zmdi zmdi-time"></i>Timesheet</a></li>
        </ul>
    </div>
</aside>