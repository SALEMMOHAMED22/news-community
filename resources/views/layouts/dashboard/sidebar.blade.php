
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">  News Admin </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
           
@can('home')
<li class="nav-item active">
    <a class="nav-link" href="{{ route('admin.home') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>
    
@endcan
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Options
            </div>

            <!-- Nav Item - Post Mangement -->
          @can('posts')
          <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-table"></i>
                <span>Posts Management</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Posts Management</h6>
                    <a class="collapse-item" href="{{ route('admin.posts.index') }}">Posts</a>
                    <a class="collapse-item" href="{{ route('admin.posts.create') }}">Create Post</a>
                </div>
            </div>
        </li>
          @endcan

          @can('categories')
          <li class="nav-item">
           <a class="nav-link" href="{{ route('admin.categories.index') }}">
               <i class="fas fa-fw fa-tags"></i>
               <span>Categories</span></a>
       </li>
          @endcan

            <!-- Nav Item - User Mangement -->
            @can('users')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users Management</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.users.index') }}">Users</a>
                        <a class="collapse-item" href="{{ route('admin.users.create') }}">Add User</a>
                        
                        
                    </div>
                </div>
            </li>
            @endcan

             <!-- Nav Item - Admin Mangement -->
             @can('admins')
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#adminManagement"
                    aria-expanded="true" aria-controls="adminManagement">
                    <i class="fas fa-fw fa-users"></i>
                    <span>
                        Admins Management</span>
                </a>
                <div id="adminManagement" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.admins.index') }}">Admins</a>
                        <a class="collapse-item" href="{{ route('admin.admins.create') }}">Add New Admin</a>
                        
                        
                    </div>
                </div>
            </li>
             @endcan

             <!-- Nav Item - Roles Mangement -->
           @can('authorizations')
           <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#authorizations"
                aria-expanded="true" aria-controls="authorizations">
                <i class="fas fa-fw fa-cog"></i>
                <span>
                    Roles Management</span>
            </a>

            <div id="authorizations" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.authorizations.index') }}">Roles</a>
                    <a class="collapse-item" href="{{ route('admin.authorizations.create') }}">Add New Role</a>
                    
                </div>
            </div>
        </li>
           @endcan




            <!-- Nav Item - Settings Management -->
           @can('settings')
           <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-cog"></i>
                <span>Settings Management</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"

                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Settings Management</h6> --}}
                    <a class="collapse-item" href="{{ route('admin.settings.index') }}">settings</a>
                    <a class="collapse-item" href="{{ route('admin.related-site.index') }}">Related Sites</a>
                    
                </div>
            </div>
        </li>
           @endcan
              <!-- Nav Item - Categories -->
         


           @can('contacts')
           <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-fw fa-comments"></i>
                <span>Contacts</span></a>
        </li>
           @endcan
           
           @can('notifications')
           <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                <i class="fas fa-fw fa-bell"></i>

                <span>Notifications</span></a>
        </li>
           @endcan

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
                Addons
            </div> --}}

            <!-- Nav Item - Pages Collapse Menu -->
           
            
           
            {{-- <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li> --}}

           

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
