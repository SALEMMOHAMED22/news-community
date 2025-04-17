 <!-- Top Bar Start -->
 <div class="top-bar">
     <div class="container">
         <div class="row">
             <div class="col-md-6">
                 <div class="tb-contact">
                     <p><i class="fas fa-envelope"></i>{{ $getSetting->email }}</p>
                     <p><i class="fas fa-phone-alt"></i>{{ $getSetting->phone }}</p>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="tb-menu">
                     @guest
                         <a href="{{ route('register') }}">Register</a>
                         <a href="{{ route('login') }}">Login</a>
                     @endguest
                     @auth

                         <a href="javascript:void(0)"
                             onclick="if(confirm('Do You Want To Logout!')){document.getElementById('formLogout').submit()} return false">Logout</a>
                     @endauth
                     <a href="{{ route('frontend.contact.index') }}">Contact</a>
                     <form id="formLogout" action="{{ route('logout') }}" method="post">
                         @csrf
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Top Bar Start -->

 <!-- Brand Start -->
 <div class="brand">
     <div class="container">
         <div class="row align-items-center">
             <div class="col-lg-3 col-md-4">
                 <div class="b-logo">
                     <a href="index.html">
                         <img src="{{ asset( $getSetting->logo) }}" alt="Logo" />
                     </a>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4">

             </div>
             <div class="col-lg-3 col-md-4">
                 <form action="{{ route('frontend.search') }}" method="POST">
                     @csrf
                     <div class="b-search">
                         <input name="search" type="text" placeholder="Search" />
                         <button type="submit"><i class="fa fa-search"></i></button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- Brand End -->

 <!-- Nav Bar Start -->
 <div class="nav-bar">
     <div class="container">
         <nav class="navbar navbar-expand-md bg-dark navbar-dark">
             <a href="#" class="navbar-brand">MENU</a>
             <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                 <span class="navbar-toggler-icon"></span>
             </button>

             <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                 <div class="navbar-nav mr-auto">
                     <a href="{{ route('frontend.index') }}" class="nav-item nav-link active">Home</a>
                     <div class="nav-item dropdown">
                         <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                         <div class="dropdown-menu">
                             @foreach ($categories as $category)
                                 <a href="{{ route('frontend.category.posts', $category->slug) }}"
                                     class="dropdown-item" title="{{ $category->name }}">{{ $category->name }}</a>
                             @endforeach
                         </div>
                     </div>
                     <a href="{{ route('frontend.contact.index') }}" class="nav-item nav-link">Contact Us</a>
                     <a href="{{ route('frontend.dashboard.profile') }}" class="nav-item nav-link">Account</a>
                 </div>
                 <div class="social ml-auto">
                     <!-- Notification Dropdown -->
                    @auth
                    
                    <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span id="count-notification" class="badge badge-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                        style="width: 300px;">
                        <a href="{{ route('frontend.dashboard.notification.readAll') }}"
                            class="dropdown-header">Mark All </a>

                        @if (auth()->user()->unreadNotifications->count() > 0)
                            @foreach (auth()->user()->unreadNotifications as $notify)
                                <div id="push-notification">
                                    <div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span>Post comment: {{substr($notify->data['post_title'], 0, 9)}} ...
                                        </span>
                                        <a href="{{ route('frontend.post.show' , $notify->data['post_slug']) }}}?notify={{ $notify->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>


                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="dropdown-item text-center">No notifications</div>
                        @endif
                    </div>
                
         
                    @endauth

                 <!-- <div class="dropdown-item text-center">No notifications</div>  -->

           
             <a href="{{ $getSetting->twitter }}" title="twitter"><i class="fab fa-twitter" rel="unfollow" ></i></a>
             <a href="{{ $getSetting->facebook }}" title="facebook"><i class="fab fa-facebook-f"  rel="unfollow" ></i></a>
             <a href="{{ $getSetting->instagram }}" title="instagram"><i class="fab fa-instagram"  rel="unfollow" ></i></a>
             <a href="{{ $getSetting->youtube }}" title="youtube"><i class="fab fa-youtube"  rel="unfollow" ></i></a>
            </div>
        </div>

     </div>
 </div>
 </nav>
 </div>
 </div>
 <!-- Nav Bar End -->
