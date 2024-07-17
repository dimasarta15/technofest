<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @yield('menuDashboard')">
            <a class="nav-link" href="{{ route(getLang().'backsite.dashboard.index') }}">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @can('access-superadmin')
            <li class="nav-item @yield('menuSetting')">
                <a class="nav-link" data-bs-toggle="collapse" href="#form-setting" aria-expanded="false" aria-controls="form-setting">
                <i class="menu-icon mdi mdi-settings"></i>
                <span class="menu-title">@trans('backsite.setting')</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse @yield('collapseSetting')" id="form-setting">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item @yield('menuGeneral')"><a class="nav-link" href="{{ route(getLang().'backsite.setting.index') }}">@trans('backsite.general')</a></li>
                        <li class="nav-item @yield('menuRole')"><a class="nav-link @yield('menuRole')" href="{{ route(getLang().'backsite.role.index') }}">@trans('backsite.role')</a></li>
                        <li class="nav-item @yield('menuSemester')"><a class="nav-link @yield('menuSemester')" href="{{ route(getLang().'backsite.semester.index') }}">@trans('backsite.semester')</a></li>
                        <li class="nav-item @yield('menuCategory')"><a class="nav-link @yield('menuCategory')" href="{{ route(getLang().'backsite.category.index') }}">@trans('backsite.category')</a></li>
                        <li class="nav-item @yield('menuMajor')"><a class="nav-link @yield('menuMajor')" href="{{ route(getLang().'backsite.major.index') }}">@trans('backsite.major')</a></li>
                        <li class="nav-item @yield('menuLang')"><a class="nav-link @yield('menuLang')" href="{{ route(getLang().'backsite.language.index', ['lang' => 'en']) }}">@trans('backsite.language')</a></li>                    </ul>
                </div>
            </li>
        @endcan
        
        @can('access-superadmin')
        <li class="nav-item @yield('menuLecture')">
            <a class="nav-link" href="{{ route(getLang().'backsite.lecture.index') }}">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">@trans('backsite.lecturer')</span>
            </a>
        </li>
        @endcan
        
        <!-- <li class="nav-item nav-category">Forms and Datas</li> -->
        @can('access-superadmin-moderator')
            <li class="nav-item @yield('menuUser')">
                <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-account-key"></i>
                <span class="menu-title">@trans('backsite.user')</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse @yield('collapseUser')" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                        @php
                        $userMenu = \App\Models\Role::all();
                        if (Auth::user()->role_id == \App\Models\Role::ROLES['moderator']) {
                            $userMenu = \App\Models\Role::where('role', '!=', 'superadmin')->get();
                        }
                        @endphp
                        @forelse ($userMenu as $v)
                            <li class="nav-item @yield('menu'.str_replace(' ', '', ucfirst($v->role)))">
                                <a class="nav-link" href="{{ route(getLang().'backsite.user.index', ['?role=' . $v->ref]) }}">{{ ucfirst($v->role) }}</a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </li>
        @endcan
        <li class="nav-item @yield('menuProject')">
            <a class="nav-link" href="{{ route(getLang().'backsite.project.index') }}">
            <i class="mdi mdi mdi-checkbox-multiple-blank-outline menu-icon"></i>
            <span class="menu-title">@trans('backsite.project')</span>
            </a>
        </li>
        @can('access-superadmin-moderator')
            <li class="nav-item @yield('menuSpeaker')">
                <a class="nav-link" href="{{ route(getLang().'backsite.speaker.index') }}">
                <i class="mdi mdi mdi-forum menu-icon"></i>
                <span class="menu-title">@trans('backsite.speaker')</span>
                </a>
            </li>
            <li class="nav-item @yield('menuAgenda')">
                <a class="nav-link" href="{{ route(getLang().'backsite.agenda.index') }}">
                <i class="mdi mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">@trans('backsite.agenda')</span>
                </a>
            </li>
        @endcan
        @can('access-superadmin-moderator')
            <li class="nav-item @yield('menuEvent')">
                <a class="nav-link" href="{{ route(getLang().'backsite.event.index') }}">
                <i class="mdi mdi-calendar-text menu-icon"></i>
                <span class="menu-title">@trans('backsite.event')</span>
                </a>
            </li>
        @endcan

        @can('access-superadmin-moderator')
        <li class="nav-item @yield('menuQuizioner')">
            <a class="nav-link" href="{{ route(getLang().'backsite.quizioner.index') }}">
            <i class="mdi mdi-comment-question-outline menu-icon"></i>
            <span class="menu-title">@trans('backsite.quizioner')</span>
            </a>
        </li>
        @endcan

        @can('access-superadmin-moderator')
            <li class="nav-item @yield('menuBackup')">
                <a class="nav-link" href="{{ route(getLang().'backsite.backup.index') }}">
                <i class="mdi mdi-backup-restore menu-icon"></i>
                <span class="menu-title">Backup</span>
                </a>
            </li>
        @endcan
    </ul>
</nav>
<!-- partial -->