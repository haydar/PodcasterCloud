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
            <span>You have already a podcast series and you wanna migrate to Podcaster Cloud Services? Don't worry, We thought about this too.</span>
            <form class="importEpisodeCard col-md-8" id="importEpisodeForm" enctype="multipart/form-data">
                <label for="importUrl">Feed URL :</label>
                <input type="url" class="form-control" name="importUrl" id="importUrl" placeholder="Paste your RSS Feed" required>
                <button type="submit" class="btn btn-info btn-lg text-white" id="importButton" style="text-transform:none;">
                <i class="nc-icon nc-cloud-upload-94"></i>  Import Episodes </button>
            </form>
            <small id="wrongFileTypeError" style="display:none;" class="form-text text-danger">You have selected a file with the wrong file type. We can accept only audio files.</small>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        var importButton=document.getElementById('importButton');
        var isFormValid = document.getElementById('importEpisodeForm').checkValidity();
        var formData= new FormData(document.getElementById('importEpisodeForm'));

        importButton.onclick = function (e) {
            var importButton=document.getElementById('importButton');
            var isFormValid = document.getElementById('importEpisodeForm').checkValidity();
            var formData= new FormData(document.getElementById('importEpisodeForm'));

            if (isFormValid)
            {
                e.preventDefault();
                $.ajax({
                url:"{{route('podcast.importepisode',[$podcast->slug])}}",
                dataType:'JSON',
                type:'POST',
                enctype: 'text/plain',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:formData,
                success:function(result){
                    swal({
                            type: 'success',
                            title: "Episodes importing started! We will notify you when it's done",
                    });
                },
                error:function(result){
                    var $data=jQuery.parseJSON(result.responseText);
                    $errors="";

                    if (result.status=='422')
                    {
                        Object.keys($data.errors).forEach(key => {
                            $data.errors[key].forEach(errorMessage => {
                                $errors+=errorMessage+'<br>';
                            });
                        });

                        swal({
                            type: 'error',
                            title: 'Oops...',
                            html:$errors
                        });
                    }
                    else
                    {
                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: $data.message,
                        });
                    }
                    },
                });
            }
        }
    });

</script>
@endsection
