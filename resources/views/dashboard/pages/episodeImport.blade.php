@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('css')
<style>
    html,
    body {
        height: 100%;
    }
</style>
@endsection

@section('content')
<div class="content h-100">
    <div class="card bg-light h-50" id="importEpisodeCard">
        <div class="card-body border-dashed d-flex flex-column align-items-center text-center justify-content-center" id="dropSection">
            <span>Okay, you ready for upload your awesome episode. You can use the drag and drop or click to upload button.</span>
            <form  class="importEpisodeCard col-md-8" id="importEpisodeCard" enctype="multipart/form-data">
                <label for="importUrl">Feed URL :</label>
                <input type="url" class="form-control" required name="importUrl" id="importUrl" placeholder="Paste your RSS Feed">
                <button type="button" class="btn btn-info btn-lg text-white" id="importButton" style="text-transform:none;">
                <i class="nc-icon nc-cloud-upload-94"></i>  Import Episodes </button>
            </form>
            <small id="wrongFileTypeError" style="display:none;" class="form-text text-danger">You have selected a file with the wrong file type. We can accept only audio files.</small>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){

    });
</script>
@endsection
