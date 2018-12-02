@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @isset($episodes)
            <div class="card">
                    <div class="card-header">
                        <h3>{{$podcast->name}}'s Episodes</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="text-primary">
                                <tr >
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
                                            <form role="form" method="POST" id="deleteEpisode" action="{{route('podcast.destroy',$episode->id)}}">
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
            </div>
            @endisset
        </div>
    </div>
</div>
@endsection
