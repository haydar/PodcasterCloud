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
    <div class="card bg-light h-50" id="uploadAudioCard">
        <div class="card-body border-dashed d-flex flex-column align-items-center text-center justify-content-center">
            <span>Okay, you ready for upload your awesome episode. You can use the drag and drop or click to upload button.</span>
            <form  class="uploadAudioForm" id="uploadAudioForm" enctype="multipart/form-data">
                <input type="file" required hidden accept=".mp3,.m4a,.mp4,.m4r" name="audio" id="audioInput">
                <button type="button" class="btn btn-success btn-lg text-white" id="uploadButton" style="text-transform:none;">
                <i class="nc-icon nc-cloud-upload-94"></i>  Create Episode </button>
            </form>
            <small id="wrongFileTypeError" style="display:none;" class="form-text text-danger">You have selected a file with the wrong file type. We can accept only audio files.</small>
        </div>
    </div>
    <div class="card" style="display:none;" id="createEpisodeCard">
        <div class="card-header text-center">
            Create A Episode
        </div>
        <div class="card-body h-100">
            <div class="progress">
                <div class="progress-bar justify-content-center" id="fileProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                    aria-valuemax="100" style="width: 0%;">
                    <span id="fileUploadPercent" class="text-center">ddd</span>
                </div>
            </div>
            <span class="text-center" id="progressBarStatus"></span><br>
            <form action="" method="post" id="createEpisodeForm">
                <div class="col-md-4 float-left">
                    <div class="form-group row">
                        <label for="artwork-image">Episode Image (Optinal)</label>
                    </div>
                    <div class="form-group row justify-content-center">
                        <img  height="70%" width="70%" id="podcastImage"  src="{{$podcast->getArtworkImagePath()}}">
                    </div>
                    <div class="form-group row justify-content-center">
                        <button  class="btn btn-info">
                            <i class="nc-icon nc-cloud-upload-94"></i> Upload Custom Image
                            <input type="file" accept=".jpg,.gif,.png,.jpeg,.gif,.svg" name="image" class="form-control-file"  id="image">
                        </button>
                    </div>
                </div>
                <div class="col-md-8 float-right">
                    <input type="hidden" name="audioFile" id="audioFile">
                    <div class="form-group">
                        <label class="font-weight-bold" for="title">Title :</label>
                        <input type="text" class="form-control" required name="title" placeholder="Type episode title..." id="title">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="description">Description :</label>
                        <textarea id='editor'  name="description" rows="10" cols="20"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="explicit">Explicit :</label>
                        <input type="radio" required name="explicit" value="1"> Yes
                        <input type="radio" required checked name="explicit" value="0"> No
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="createEpisode">Create new episode</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        let editor;
        var textarea=document.querySelector('#editor');
        ClassicEditor.create(textarea,
        {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote','ImageUpload'],
        })
        .then( newEditor => {
            editor = newEditor;
            editor.ui.view.editable.editableElement.style.height = '150px';
        })
        .catch( error => {
            console.error( error );
        });

        //Show fileDialog when clicked uploadButton
        $(document).on('click','#uploadButton', function(){
            var uploadButton=$('#audioInput');
            uploadButton.click();
        });

        //
        $(document).on('change','#audioInput', function(e){
            e.preventDefault();
            var file = e.currentTarget.files[0];
            var formData=new FormData($('#uploadAudioForm')[0]);

            var fileProgressBar=$('#fileProgressBar');
            var fileUploadPercent=$('#fileUploadPercent');
            var progressBarStatus=document.getElementById('progressBarStatus');

            if (file.type==="audio/mp3"||file.type==="video/mp4") {
                $('#wrongFileTypeError').hide();
                $('#uploadAudioCard').fadeOut(1000);
                $('#createEpisodeCard').fadeIn(1000);
                $.ajax({
                    url:"{{route('podcast.episode.upload',$podcast->slug)}}",
                    dataType:'JSON',
                    type:'POST',
                    enctype: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:formData,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        //Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total * 100).toFixed(2);
                                var percentVal = percentComplete + '%';
                                fileProgressBar.css('width',percentVal);
                                fileUploadPercent.html(percentVal);
                            }
                        }, false);

                        return xhr;
                    },
                    beforeSend:function() {
                        fileProgressBar.width('0%');
                        progressBarStatus.textContent="File Uploading..."
                    },
                    success:function(result){
                        var audioFile=document.getElementById('audioFile');
                        audioFile.value=result.audioFileId;
                        progressBarStatus.textContent="File Uploaded. You are ready for creating episode."
                    },
                    error:function(result){
                        var $data=JSON.parse(result.responseText);
                        var $errors='';

                        Object.keys($data.errors).forEach(key => {
                            $data.errors[key].forEach(errorMessage => {
                                $errors+=errorMessage+'<br>';
                            });
                        });
                        fileUploadPercent.html('0%');
                        fileProgressBar.width('0%');
                        progressBarStatus.textContent="File Upload Failed, Please refresh page and try again..."
                        swal({
                                type: 'error',
                                title: 'Oops...',
                                html:$errors
                        });
                    }
                });
            } else {
                $('#wrongFileTypeError').show();
            }
        });

        //Create New Episode Button
        var createEpisodeButton=document.getElementById('createEpisode');

        createEpisodeButton.onclick = function(e){
            var audioFileId=document.getElementById('audioFile').value;
            var formData=new FormData(document.getElementById('createEpisodeForm'));
            var isFormValid=document.getElementById('createEpisodeForm').checkValidity();
            formData.append('description',editor.getData());
            console.log('Audio File ID null status : '+ (audioFileId==""));
            console.log('number valid : ' +(!isNaN(audioFileId)));
            var audioFileValid=(!isNaN(audioFileId))&&(!audioFileId=="");
            console.log('Audio File Valid'+audioFileValid);

            if(audioFileValid&&isFormValid)
            {
                e.preventDefault();
                $.ajax({
                    url:"{{route('podcast.episode.store',$podcast->slug)}}",
                    dataType:'JSON',
                    type:'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:formData,
                    success:function(result){
                        swal({
                                type: 'success',
                                title: 'Episode Created!',
                        });
                        document.getElementById('createEpisodeForm').reset();
                        document.getElementById('uploadAudioForm').reset();
                        $('#uploadAudioCard').fadeIn(1000);
                        $('#createEpisodeCard').fadeOut(1000);
                        editor.setData('');

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
                    },
                });
            }
            else
            {
                if (isFormValid)
                {
                    e.preventDefault();
                    swal({
                        type: 'warning',
                        title: 'Please Wait',
                        text:'Your file is still uploading...'
                    });
                }

            }
        }
    });

</script>
@endsection
