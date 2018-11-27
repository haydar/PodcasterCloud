@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>{{$podcast->name}}'s statistics will be here soon</h3>
        </div>
    </div>
</div>
@endsection
