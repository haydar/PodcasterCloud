@extends('custom.layouts.master')
@section('content')
<div class="row justify-content-center align-items-center mx-auto h-100">
        <div class="col-md-6 text-center my-2">
            <label class="btn btn-primary">Create a new Podcast</label>
        </div>
        @isset($podcasts)
        <table class="table">
            <thead>
                <tr>
                    <th>Podcast Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($podcasts as $podcast)
                <tr>
                    <td>{{ $podcast->title }}</td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('podcast.show', $podcast->slug) }}" class="btn btn-info btn-md">Manage Podcast</a>
                            </div>
                            <div class="col-md-1">
                                <form role="form" method="POST" action="{{route('podcasts.destroy',$podcast->id)}}">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn btn-danger">Sil</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endisset
</div>
@endsection
