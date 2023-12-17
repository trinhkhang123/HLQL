<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      
      <div class="sidebar-brand-text mx-3">Quản lý huấn luyện</div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    
    <!-- Nav Item - Dashboard -->
    {{-- @if(auth()->user()->type_user == 'admin') --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Điểm danh</span>
      </a>
    </li>

    
    <li class="nav-item">
      <a class="nav-link" href="{{ route('products') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Danh sách sinh viên</span></a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" href="/cacula">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Thêm thời khóa biểu</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/thuchien">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Thuc hien ke hoach</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/thongkedonvi">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Quản lý trang thiết bị </span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/thongkedonvi">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Thong ke don vi </span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/unit">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Quản lý đơn vị </span></a>
    </li>
    {{-- @endif --}}
    @if(auth()->user()->type_user == 'Học viên')
    
   
    
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    
    
  </ul>