
@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3>{{$episode->title}}</h3>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    });
</script>
@endsection
