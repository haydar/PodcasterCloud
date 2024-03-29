<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute">
    <div class="container-fluid">

        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" id='navbar-podcastName' href="#">@isset($podcast->name) {{$podcast->name." Podcast"}} @endisset</a>

        <a class="btn btn-round btn-success btn-sm text-white ml-4" href="{{route('podcast.episode.create',$podcast->slug)}}" style="text-transform:none;">
                <i class="nc-icon nc-cloud-upload-94"></i> <span class="d-none d-md-inline-block">Create Episode</span>
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="nc-icon nc-bell-55"></i>
                          <p>
                            <span class="d-lg-none d-md-block">Some Actions</span>
                          </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right show" aria-labelledby="navbarDropdownMenuLink">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nc-icon nc-single-02"></i>
                            <p>
                                <span class="d-none d-md-block" id="navbar-username">{{Auth::user()->name}}</span>
                                <span class="d-lg-none d-md-block">Account</span>
                            </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{route('user.show',[Auth::id(),$podcast->slug])}}">Your Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">Logout</a>
                         <form id="logout-form" action="{{url('/logout')}}" method="POST" style="display: none;">
                           @csrf
                         </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
