@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    @empty($podcast->episode)
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header">
                <h6 class="text-capitalize mb-0">No one at the home yet  <i class="fa fa-home"></i></h6>
            </div>
            <div class="card-body">
                <p class="mb-0">You started your broadcasting life with a clean page. You can upload new one episode or import existing podcast series.</p>
                <a class="btn btn-success btn-sm text-white" href="{{route('podcast.episode.create',$podcast->slug)}}" style="text-transform:none;">
                        <i class="nc-icon nc-cloud-upload-94"></i> <span class="d-none d-md-inline-block">Create Episode</span>
                </a>
                <a class="btn btn-sm btn-info text-capitalize text-white"><i class="fa fa-rss"></i> Import RSS</a>
            </div>
        </div>
    </div>
    @endempty
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header">
                <h3>{{$podcast->name}}'s statics will be here soon</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
</script>
@endsection
