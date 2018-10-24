<div class="sidebar" data-color="black" data-active-color="danger">
        <!--Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"-->
        <div class="logo">
        <a href="{{url('/')}}" class="simple-text logo-mini">
                <div class="logo-image-small">
                </div>
            </a>
            <a href="{{url('/')}}" style="text-transform:none" class="simple-text logo-normal">
                Podcaster Cloud
                <!-- <div class="logo-image-big">
                  <img src="../assets/img/logo-big.png">
                </div> -->
              </a>
        </div>
        <div class="sidebar-wrapper ps-container ps-theme-default ps-active-x" data-ps-id="dbffba71-a360-4705-1a8a-5ef820a81fef">
            <ul class="nav">
                <li class="{{ Request::is('manage/podcast/'.$podcast->slug.'') ? 'active' : 'no' }}">
                    <a href="{{route('podcast.show',$podcast->slug)}}">
                        <i class="nc-icon nc-bank"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="{{ Request::is('manage/podcast/*') ? 'active' : 'no' }}">
                    <a data-toggle="collapse" href="#episodeSection" class="collapse justify-align-center">
                        <i class="nc-icon nc-bullet-list-67"></i>
                        <p>
                            Episodes
                            <b class="caret mt-2"></b>
                        </p>
                    </a>
                    <div class="collapse" id="episodeSection" style="">
                        <ul class="nav">
                            <li>
                                <a class="ml-5 text-capitalize" href="">
                                    <span class="sidebar-normal"> All Episodes </span>
                                </a>
                            </li>
                            <li>
                                <a class="ml-5 text-capitalize"href="">
                                    <span class="sidebar-normal"> Upload Episodes </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="">
                        <i class="nc-icon nc-pin-3"></i>
                        <p>Maps</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="nc-icon nc-bell-55"></i>
                        <p>Notifications</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="nc-icon nc-single-02"></i>
                        <p>User Profile</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="nc-icon nc-tile-56"></i>
                        <p>Table List</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="nc-icon nc-caps-small"></i>
                        <p>Typography</p>
                    </a>
                </li>
            </ul>
            <div class="ps-scrollbar-x-rail" style="width: 260px; left: 0px; bottom: 0px;">
                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 258px;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
    </div>
