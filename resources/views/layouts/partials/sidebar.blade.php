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
            <li class={{ Route::is('dashboard') ? "navigation__active" : ""}}>
                <a href="{{ route('dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i>Dashboard</a>
            </li>
            <hr>

            @can('view', App\User::class)
                <li class={{ Route::is('users*') ? "navigation__active" : ""}}>
                    <a href="{{ route('users.index') }}"><i class="zmdi zmdi-accounts-list"></i>Users</a>
                </li>
            @endcan
            @can('view', App\Role::class)
                <li class={{ Route::is('roles*') ? "navigation__active" : ""}}>
                    <a href="{{ route('roles.index') }}"><i class="zmdi zmdi-face"></i>Roles</a>
                </li>
            @endcan
            @canany('view', [App\Role::class, App\User::class])
                <hr>
            @endcanany

            @canany('view', [App\Playbooks\Entry::class, App\Playbooks\Category::class])
                <li class="navigation__sub {{ Route::is(['entries*', 'categories*']) ? "navigation__active" : ""}}">
                    <a href=""><i class="zmdi zmdi-collection-text"></i> Playbooks</a>
                    <ul>
                        @can('view', App\Playbooks\Entry::class)
                            <li class={{ Route::is('entries*') ? "navigation__active" : ""}}>
                                <a href="{{ route('entries.index') }}">Entries</a>
                            </li>
                        @endcan
                        @can('view', App\Playbooks\Category::class)
                                <li class={{ Route::is('categories*') ? "navigation__active" : ""}}>
                                <a href="{{ route('categories.index') }}">Categories</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <hr>
            @endcanany

            <li><a href=""><i class="zmdi zmdi-developer-board"></i>Tasks</a></li>
            <li class={{ Route::is('calendar*') ? "navigation__active" : ""}}>
                <a href="{{ route('calendar.index') }}"><i class="zmdi zmdi-calendar-alt"></i>Calendar</a>
            </li>
            <li><a href=""><i class="zmdi zmdi-time"></i>Timesheet</a></li>
        </ul>
    </div>
</aside>