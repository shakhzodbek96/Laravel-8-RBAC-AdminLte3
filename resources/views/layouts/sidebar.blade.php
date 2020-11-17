{{--Left sidebar--}}
<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="fas fa-users-cog"></i>
                <p>
                    @lang('cruds.userManagement.title')
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-3" style="display: none;">
                <li class="nav-item">
                    <a href="{{ route('permissionIndex') }}" class="nav-link">
                        <i class="fas fa-key"></i>
                        <p> @lang('cruds.permission.title_singular')</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('roleIndex') }}" class="nav-link">
                        <i class="fas fa-user-lock"></i>
                        <p> @lang('cruds.role.fields.roles')</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('userIndex') }}" class="nav-link">
                        <i class="fas fa-user-friends"></i>
                        <p> @lang('cruds.user.title')</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</nav>
