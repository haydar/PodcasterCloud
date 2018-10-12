@extends('custom.layouts.master')
@section('content')
<div class="row justify-content-center align-items-center mx-auto h-100">
        <div class="col-md-6 text-center my-2">
            <a href="{{route('podcast.create')}}" class="btn btn-primary">Create a new Podcast</a>
        </div>
        @isset($podcasts)
        <table class="table col-md-8 bg-white">
            <thead>
                <tr>
                    <th>Podcast Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($podcasts as $podcast)
                <tr>
                    <td class="col-md-6">{{ $podcast->name }}</td>
                    <td class="col-md-3">
                        <div>
                            <a href="{{ route('podcast.show', $podcast->slug) }}" class="btn btn-success btn-md">Manage Podcast</a>
                        </div>
                    </td>
                    <td class="col-md-3">
                        <form role="form" method="POST" action="{{route('podcast.destroy',$podcast->id)}}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endisset
</div>
@endsection
