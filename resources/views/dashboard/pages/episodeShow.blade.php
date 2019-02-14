@extends('dashboard.layouts.master') @section('title',$podcast->name) @section('content')
<div class="content">
    <div class="card">
        <div class="card-header text-center">
            <h3>Editing Episode</h3>
        </div>
        <div class="card-body">
            <form id="editEpisodeForm" class="editEpisodeForm">
                <input type="hidden" name="_method" value="put">
                <div class="col-md-4 float-left">
                    <div class="form-group row">
                        <label for="artwork-image">Episode Image</label>
                    </div>
                    <div class="form-group row justify-content-center">
                        <img height="70%" width="70%" id="episodeImage" src="{{$episode->getImagePath()}}">
                    </div>
                    <div class="form-group row justify-content-center">
                        <button class="btn btn-info">
                            <i class="nc-icon nc-cloud-upload-94"></i> Change Custom Image
                            <input type="file" accept=".jpg,.gif,.png,.jpeg,.gif,.svg" name="image" class="form-control-file" id="image">
                        </button>
                    </div>
                </div>
                <div class="col-md-8 float-right">
                    <div class="form-group">
                        <label class="font-weight-bold" for="title">Title :</label>
                        <input type="text" class="form-control" required name="title" value="{{$episode->title}}" placeholder="Type episode title..." id="title">
                    </div>
                    <audio controls>
                        <source src="{{$episode->getAudioFilePath()}}" type="audio/ogg">
                        <source src="{{$episode->getAudioFilePath()}}" type="audio/mpeg">
                      Your browser does not support the audio player.
                    </audio>
                    <div class="form-group">
                        <label class="font-weight-bold" for="subtitle">Subtitle :</label>
                        <input type="text" class="form-control"  name="subtitle" value="{{$episode->subtitle}}" placeholder="Type episode subtitle..." id="subtitle">
                        <small class="form-text text-muted">This section is optional*</small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="description">Description :</label>
                        <textarea id='editor' name="description" rows="10" cols="20">{{$episode->description}}</textarea>
                    </div>
                    <div class="form-group">
                            <label class="font-weight-bold" for="itunesSummary">Custom iTunes Summary (optional) :</label>
                            <input type="text" class="form-control" name="itunesSummary" value="{{$episode->itunesSummary}}" placeholder="Type iTunes summary..." maxlength="255" id="itunesSummary">
                    </div>
                    <div class="form-group">
                        <label for="explicit">Explicit :</label>
                        <input type="radio" required name="explicit" value="1"> Yes
                        <input type="radio" required checked name="explicit" value="0"> No
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="updateEpisode">Update episode</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        let editor;
        var textarea = document.querySelector('#editor');
        ClassicEditor.create(textarea, {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            })
            .then(newEditor => {
                editor = newEditor;
                editor.ui.view.editable.editableElement.style.height = '150px';
            })
            .catch(error => {
                console.error(error);
            });

        //Update Episode Button
        var updateEpisodeButton = document.getElementById('updateEpisode');

        updateEpisodeButton.onclick = function(e) {

            var formData = new FormData(document.getElementById('editEpisodeForm'));

            //Set editor data to description
            formData.append('description',editor.getData());

            var isFormValid = document.getElementById('editEpisodeForm').checkValidity();
            if (isFormValid) {
                e.preventDefault();
                $.ajax({
                    url:"{{route('podcast.episode.update',[$podcast->slug,$episode->slug])}}",
                    dataType:'JSON',
                    type:'POST',
                    enctype: 'multipart/form-data',
                    contentType: false,
			        processData: false,
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:formData,
                    success:function(result){
                        swal({
                                type: 'success',
                                title: 'Episode Updated!',
                        });
                        document.getElementById('episodeImage').src=result.imagePath;
                        document.getElementById('image').value="";
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
