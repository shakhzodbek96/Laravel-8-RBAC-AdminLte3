{{--Left sidebar--}}
<nav class="mt-2">

    @canany([
        'permission.show',
        'roles.show',
        'user.show'
    ])
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'active':''}}">
                <i class="fas fa-users-cog"></i>
                <p>
                    @lang('cruds.userManagement.title')
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-3" style="display: {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'block':'none'}};">
                @can('permission.show')
                <li class="nav-item">
                    <a href="{{ route('permissionIndex') }}" class="nav-link {{ Request::is('permission*') ? "active":'' }}">
                        <i class="fas fa-key"></i>
                        <p> @lang('cruds.permission.title_singular')</p>
                    </a>
                </li>
                @endcan

                @can('roles.show')
                <li class="nav-item">
                    <a href="{{ route('roleIndex') }}" class="nav-link {{ Request::is('role*') ? "active":'' }}">
                        <i class="fas fa-user-lock"></i>
                        <p> @lang('cruds.role.fields.roles')</p>
                    </a>
                </li>
                @endcan

                @can('user.show')
                <li class="nav-item">
                    <a href="{{ route('userIndex') }}" class="nav-link {{ Request::is('user*') ? "active":'' }}">
                        <i class="fas fa-user-friends"></i>
                        <p> @lang('cruds.user.title')</p>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
    </ul>
    @endcanany
{{--    @can('card.main')--}}

{{--    @endcan--}}
</nav>
