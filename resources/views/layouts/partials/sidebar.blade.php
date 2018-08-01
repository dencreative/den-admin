<aside class="sidebar">
    <div class="scrollbar-inner">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <div>
                    <div class="user__name">{{ Auth::user()->name }}</div>
                    <div class="user__email">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="dropdown-menu">
                <a class="dropdown-item" href="">View Profile</a>
                <a class="dropdown-item" href="">Settings</a>
                <a class="dropdown-item" href="">Logout</a>
            </div>
        </div>
        <ul class="navigation">
            <li><a href="dashboard"><i class="zmdi zmdi-view-dashboard"></i>Dashboard</a></li>
            <hr>

            <li><a href="users"><i class="zmdi zmdi-accounts-list"></i>Users</a></li>
            <li><a href="roles"><i class="zmdi zmdi-face"></i>Roles</a></li>
            <hr>

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