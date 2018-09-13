<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ config('app.name')}} | Your Wonderful Podcasts</title>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>
<style>
    body, html {height: 100% !important;}
</style>
<body>
        <div class="container h-100">
                <div class="row justify-content-center align-items-center mx-auto h-100">
                    <div class="col-md-6">
                        <a href=""></a>
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
                </div>
            </div>
</body>
</html>
