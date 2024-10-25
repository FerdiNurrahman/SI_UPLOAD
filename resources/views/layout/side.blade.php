<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-name">John Doe</p>
      <p class="app-sidebar__user-designation">Frontend Developer</p>
    </div>
  </div>
  <ul class="app-menu">
    <!-- Menambahkan conditional untuk menampilkan class active pada menu yang aktif -->
    <li>
      <a class="app-menu__item {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">
        <i class="app-menu__icon bi bi-speedometer"></i>
        <span class="app-menu__label">Dashboard</span>
      </a>
    </li>

    <li>
      <a class="app-menu__item {{ Request::is('uploadFoto') ? 'active' : '' }}" href="{{ url('/uploadFoto') }}">
        <i class="app-menu__icon bi bi-ui-checks"></i>
        <span class="app-menu__label">Lihat Foto</span>
      </a>
    </li>

    <li>
      <a class="app-menu__item {{ Request::is('upload') ? 'active' : '' }}" href="{{ url('/upload') }}">
        <i class="app-menu__icon bi bi-cloud-upload"></i>
        <span class="app-menu__label">Upload Foto</span>
      </a>
    </li>
  </ul>
</aside>
