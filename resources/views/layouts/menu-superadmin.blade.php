<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @yield('menuDashboard')">
            <a class="nav-link" href="{{ route('backsite.dashboard.index') }}">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @can('access-superadmin')
            <li class="nav-item @yield('menuSetting')">
                <a class="nav-link" data-bs-toggle="collapse" href="#form-setting" aria-expanded="false" aria-controls="form-setting">
                <i class="menu-icon mdi mdi-settings"></i>
                <span class="menu-title">Pengaturan</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse @yield('collapseSetting')" id="form-setting">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item @yield('menuGeneral')"><a class="nav-link" href="{{ route('backsite.setting.index') }}">General</a></li>
                        <li class="nav-item @yield('menuRole')"><a class="nav-link @yield('menuRole')" href="{{ route('backsite.role.index') }}">Role</a></li>
                        <li class="nav-item @yield('menuSemester')"><a class="nav-link @yield('menuSemester')" href="{{ route('backsite.semester.index') }}">Semester</a></li>
                        <li class="nav-item @yield('menuCategory')"><a class="nav-link @yield('menuCategory')" href="{{ route('backsite.category.index') }}">Kategori</a></li>
                        <li class="nav-item @yield('menuMajor')"><a class="nav-link @yield('menuMajor')" href="{{ route('backsite.major.index') }}">Prodi</a></li>
                    </ul>
                </div>
            </li>
        @endcan
        <li class="nav-item @yield('menuLecture')">
            <a class="nav-link" href="{{ route('backsite.lecture.index') }}">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Dosen</span>
            </a>
        </li>
        
        <!-- <li class="nav-item nav-category">Forms and Datas</li> -->
        @can('access-superadmin-moderator')
            <li class="nav-item @yield('menuUser')">
                <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-account-key"></i>
                <span class="menu-title">User</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse @yield('collapseUser')" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                        @forelse (\App\Models\Role::all() as $v)
                            <li class="nav-item @yield('menu'.str_replace(' ', '', ucfirst($v->role)))"><a class="nav-link" href="{{ route('backsite.user.index', ['?role=' . $v->ref]) }}">{{ ucfirst($v->role) }}</a></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </li>
        @endcan
        <li class="nav-item @yield('menuProject')">
            <a class="nav-link" href="{{ route('backsite.project.index') }}">
            <i class="mdi mdi mdi-checkbox-multiple-blank-outline menu-icon"></i>
            <span class="menu-title">Karya</span>
            </a>
        </li>
        @can('access-superadmin')
            <li class="nav-item @yield('menuSpeaker')">
                <a class="nav-link" href="{{ route('backsite.speaker.index') }}">
                <i class="mdi mdi mdi-forum menu-icon"></i>
                <span class="menu-title">Pembicara</span>
                </a>
            </li>
            <li class="nav-item @yield('menuAgenda')">
                <a class="nav-link" href="{{ route('backsite.agenda.index') }}">
                <i class="mdi mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">Agenda</span>
                </a>
            </li>
        @endcan
        @can('access-superadmin-moderator')
            <li class="nav-item @yield('menuEvent')">
                <a class="nav-link" href="{{ route('backsite.event.index') }}">
                <i class="mdi mdi-calendar-text menu-icon"></i>
                <span class="menu-title">Kegiatan</span>
                </a>
            </li>
        @endcan
        <li class="nav-item @yield('menuQuizioner')">
            <a class="nav-link" href="{{ route('backsite.quizioner.index') }}">
            <i class="mdi mdi-comment-question-outline menu-icon"></i>
            <span class="menu-title">Quizioner</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->