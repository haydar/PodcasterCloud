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
                        </table>
                    </div>
            </div>
            @endisset
        </div>
    </div>
</div>
@endsection
