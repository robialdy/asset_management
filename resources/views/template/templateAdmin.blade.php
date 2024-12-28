<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

  <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">

  {{-- extension --}}
  <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="index.html"><img src="{{ asset('assets/static/images/logo/logo.svg') }}" alt="Logo"></a>
            </div>

        <div class="user-profile d-flex align-items-center justify-content-start ms-2">
            <button class="btn btn-link" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/static/images/logo/jne_profil.png') }}" alt="User Avatar" class="img-fluid rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
            </button>
             <div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton" data-popper-placement="bottom-start">
                <p class="ms-4 my-auto">{{ Auth::user()->username }}</p>
                <div class="dropdown-divider"></div>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link fw-bold ms-3">Logout</button>
                </form>
            </div>
        </div>

            {{-- DARK MODE | LIGHT MODE --}}
            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--system-uicons" width="20" height="20"
                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                            opacity=".3"></path>
                        <g transform="translate(-210 -1)">
                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                            <circle cx="220.5" cy="11.5" r="4"></circle>
                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                        </g>
                    </g>
                </svg>
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                    <label class="form-check-label"></label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                    </path>
                </svg>
            </div>

        </div>
    </div>
    <div class="sidebar-menu">

        <ul class="menu">

            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item {{ request()->is('admin') ? 'active' : '' }}">
                <a href="{{ route('admin') }}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/submission-request*') || request()->is('admin/rejuvenation-request*')  || request()->is('admin/destroy-request*') ? 'active' : '' }} has-sub">
                <a href="#" class='sidebar-link'>
                <i class="bi bi-send"></i>
                    <span>Request</span>
                </a>

                <ul class="submenu ">
                    <li class="submenu-item {{ request()->is('admin/submission-request*') ? 'active' : ''  }}">
                        <a href="{{ route('submission-request') }}" class="submenu-link">Submission <span class="badge bg-danger">4</span></a>
                    </li>
                    <li class="submenu-item {{ request()->is('admin/rejuvenation-request*') ? 'active' : ''  }}">
                    <a href="{{ route('rejuvenation-request') }}" class="submenu-link">Rejuvenation</a>
                    </li>
                    <li class="submenu-item {{ request()->is('admin/destroy-request*') ? 'active' : ''  }}">
                        <a href="{{ route('destroy-request') }}" class="submenu-link">Destroy</a>
                    </li>
                </ul>
            </li>


            <li class="sidebar-item {{ request()->is('admin/asset-ownership*') ? 'active' : '' }}">
                <a href="{{ route('asset-ownership') }}" class='sidebar-link'>
                    <i class="bi bi-card-list"></i>
                    <span>Asset Ownership</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/office-ownership') || request()->is('admin/office-ownership/*') ? 'active' : '' }}">
                <a href="{{ route('office-ownership') }}" class='sidebar-link'>
                    <i class="bi bi-card-list"></i>
                    <span>Office Ownership</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/office') || request()->is('admin/office/*') ? 'active' : '' }}">
                <a href="{{ route('office') }}" class='sidebar-link'>
                    <i class="bi bi-building-fill"></i>
                    <span>Office</span>
                </a>
            </li>


            <li class="sidebar-item {{ request()->is('admin/available-asset*') ? 'active' : '' }}">
                <a href="{{ route('assets') }}" class='sidebar-link'>
                    <i class="bi bi-boxes"></i>
                    <span>Available Assets</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/asset/destroy*') ? 'active' : '' }}">
                <a href="{{ route('asset.destroy') }}" class='sidebar-link'>
                    <i class="bi bi-trash2-fill"></i>
                    <span>Asset Destroy</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/recommendation-history*') ? 'active' : '' }}">
                <a href="{{ route('recommendation-history') }}" class='sidebar-link'>
                    <i class="bi bi-clock-history"></i>
                    <span>Request History</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('admin/user-account*') || request()->is('admin/admin-account*') ? 'active' : '' }} has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-person-fill"></i>
                    <span>Accounts</span>
                </a>

                <ul class="submenu ">
                    <li class="submenu-item {{ request()->is('admin/user-account*') ? 'active' : '' }}">
                        <a href="{{ route('admin.user.view') }}" class="submenu-link">User</a>
                    </li>

                    <li class="submenu-item {{ request()->is('admin/admin-account*') ? 'active' : '' }}">
                        <a href="{{ route('admin.view') }}" class="submenu-link">Admin</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
</div>

   <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

<div class="page-heading">
    @yield('content')
</div>


<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2024 &copy; PT JNEr</p>
        </div>
        <div class="float-end">
            <p>Craft with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://saugi.me">Robialdy</a></p>
        </div>
    </div>
</footer>
        </div>
    </div>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>

    {{-- extension --}}
    {{-- data-table --}}
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
    {{-- sweetalert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- CHOICES --}}
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>

    <script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
    </script>
    @yield('alert')


</body>

</html>
