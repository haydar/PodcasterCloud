@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    @if(!$episodes->isEmpty())
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{$podcast->name}}'s Episodes</h3>
                </div>
                <div class="card-body">
                    <div class="float-right">
                        <form action="{{route('podcast.episode.search',$podcast->slug)}}" method="post">
                            @csrf
                            <input type="text" name="search" placeholder="Type episode title..." id="search">
                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fa fa-search"></i> <span class="d-none d-md-inline-block text-capitalize">Search</span>
                            </button>
                        </form>
                    </div>
                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th class="">Episode Title</th>
                                <th class="d-none d-sm-block text-center">Publish Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($episodes as $episode)
                            <tr class="">
                                <td class="text-truncate" style="max-width: 150px;">{{$episode->title}}</td>
                                <td class="d-none d-sm-block text-center">{{$episode->created_at}}</td>
                                <td class="text-right">
                                    <a href="{{ route('podcast.episode.show',[$podcast->slug,$episode->slug]) }}" class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                    <span class="d-none d-md-inline-block text-capitalize">Edit</span>
                                            </a>
                                </td>
                                <td class="">
                                    <form role="form" method="POST" id="deleteEpisode" action="{{route('podcast.episode.destroy',[$podcast->slug,$episode->slug])}}">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="nc-icon nc-simple-remove"></i>
                                                <span class="d-none d-md-inline-block text-capitalize">Delete</span>
                                         </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3 d-flex justify-content-center">
                        <div class="pl-3" id="episodes-pagination">
                            Showing {{$episodes->perPage()}} to {{$episodes->total()}} of episodes.
                        </div>
                    </div>
                    <div class="col-md-9 d-flex col-sm-12 justify-content-center">
                        {{ $episodes->links() }}
                    </div>
                </div>
                @else
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
                            <a class="btn btn-sm btn-info text-capitalize text-white" href="{{route('podcast.importPage',$podcast->slug)}}"><i class="fa fa-rss"></i> Import RSS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
        $(document).on('submit','#deleteEpisode', function(e){
            var line=$(this).closest('tr');
            console.log(line);
            e.preventDefault();
            swal({
                    title: 'Are you sure you want delete this episode?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                         $.ajax({
                            url:$(this).attr("action"),
                            type:'DELETE',
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(result){
                                swal(
                                'Deleted!',
                                'Your episode has been deleted.',
                                'success'
                                );
                                line.fadeOut(1000);
                            }
                        });
                    }
                })
        });
    });
    </script>
@endsection
