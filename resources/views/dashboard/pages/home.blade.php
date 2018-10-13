@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>{{$podcast->name}}</h3>
        </div>
    </div>
</div>
@endsection
