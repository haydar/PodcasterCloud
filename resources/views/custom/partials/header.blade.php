<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ config('app.name')}} | Your Wonderful Podcasts</title>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<style>
        body,html {
        background:url({{asset('img/podcastercloudbackground.jpg')}}) no-repeat !important;

        height: 100%;
        /* Center and scale the image nicely */
        background-position: center !important;;
        background-repeat: no-repeat !important;
        background-size: cover !important;

        }
    </style>
@yield('css')
</head>
<body>
    <div class="container h-100">
