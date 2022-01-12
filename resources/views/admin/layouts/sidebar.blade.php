<div class="page">
  <div class="sidebar <?= (isset($_COOKIE['sidebar_opened']) && $_COOKIE['sidebar_opened'] == 'true') ? 'no-sidebar' : '' ?>">
    <div class="sidebar-content">
      <div class="sidebar-header">
        <svg class="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="32" height="32" class="__web-inspector-hide-shortcut__">
          <circle cx="24" cy="24" r="24" style="fill: rgba(120,130,140,0.7);"></circle>
          <circle cx="24" cy="0" r="2" fill="#ffffff" class="brand-animate"></circle>
          <text dy="10" x="50%" y="50%" text-anchor="middle" style="fill: #ffffff; stroke: none; font-size: 40px;">z</text>
        </svg>
        <span class="brand">Dashboard v.1</span>
      </div>
      <hr class="sidebar-divider">
      <div class="sidebar-nav">
        <ul class="list-unstyled">
          <li class="nav-item">
            <a data-pjax  class="nav-link data-pjax "
                href="{{$this->url('app-admin')}}">
              <i class="fa fa-tachometer-alt fa-fw" aria-hidden="true"></i><span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item item-dropdown ">
            <a class="nav-link " href="#">
              <i class="fa fa-users fa-fw" aria-hidden="true"></i><span>Users</span>
            </a>
            <i class="item-dropdown-toggle fas fa-angle-right"></i>
            <ul class="list-unstyled item-dropdown-menu">
              <li class="sub-nav-item"><a data-pjax class="sub-nav-link "
                  href="{{$this->url('app-admin/users')}}">Users Manage</a></li>
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">facebook</a></li>
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">instagram</a></li>
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">youtube</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fa fa-money-bill-alt fa-fw" aria-hidden="true"></i><span>Check out </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fa fa-tag fa-fw" aria-hidden="true"></i><span>Categories</span>
            </a>
          </li>
          <li class="nav-item item-dropdown">
            <a class="nav-link" href="#">
              <i class="fa fa-users fa-fw" aria-hidden="true"></i><span>Users</span>
            </a>
            <i class="item-dropdown-toggle fas fa-angle-right"></i>
            <ul class="list-unstyled item-dropdown-menu">
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">google</a></li>
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">facebook</a></li>
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">instagram</a></li>
              <li class="sub-nav-item"><a class="sub-nav-link" href="#">youtube</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/app-admin/auth/login">
              <i class="fa fa-tag fa-fw" aria-hidden="true"></i><span>Video</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
