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
            <li class="{{ Request::is('*/podcast/'.$podcast->slug.'') ? 'active' : 'no' }}">
                <a href="{{route('podcast.show',$podcast->slug)}}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ Request::is('manage/podcast/*/episode/*/') ? 'active' : 'no' }}">
                <a data-toggle="collapse" href="#episodeSection" class="collapse justify-align-center">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>
                        Episodes
                        <b class="caret mt-2"></b>
                    </p>
                </a>
                <div class="collapse {{ Request::is('manage/podcast/*/episode/*') ? 'show' : 'no' }}" href="{{route('podcast.episode.index',$podcast->slug)}}" id="episodeSection" style="">
                    <ul class="nav">
                        <li class="{{ Request::is('manage/podcast/*/episode') ? 'active' : 'no' }}">
                        <a class="ml-5 text-capitalize {{ Request::is('manage/podcast/*/episode') ? 'active' : 'no' }}" href="{{route('podcast.episode.index', $podcast->slug)}}">
                                <span class="sidebar-normal"> All Episodes</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('manage/podcast/*/episode/create') ? 'active' : 'no' }}">
                            <a class="ml-5 text-capitalize" href="{{route('podcast.episode.create',$podcast->slug)}}">
                                <span class="sidebar-normal"> Create Episode</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{route('podcast.index')}}">
                    <i class="nc-icon nc-minimal-left"></i>
                    <p>Return Podcasts</p>
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
