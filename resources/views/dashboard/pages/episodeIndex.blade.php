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
                                <tr>
                                    <th>Episode Title</th>
                                    <th>Publish Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($episodes as $episode)
                                    <tr>
                                        <td>{{$episode->title}}</td>
                                        <td>{{$episode->created_at}}</td>
                                        <td class="text-right">
                                            <a href="{{ route('podcast.episode.show',[$podcast->slug,$episode->slug]) }}" class="btn btn-success btn-sm">
                                                    <i class="nc-icon nc-ruler-pencil"></i> Edit
                                            </a>
                                        </td>
                                        <td class="">
                                            <form role="form" method="POST" id="deleteEpisode" action="{{route('podcast.destroy',$episode->id)}}">
                                                <button type="submit" class="btn btn-danger">
                                                        <i class="nc-icon nc-simple-remove"></i> Delete
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
