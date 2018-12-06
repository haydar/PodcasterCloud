
@extends('dashboard.layouts.master')
@section('title',$podcast->slug)
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-user">
                    <div class="card-body text-center">
                        <div class="author position-relative mt-0">
                            <div id="statusUpdateAvatar" class="d-flex justify-content-center justify-align-center" style="display:none !important">
                                <img class="loading" id="#loading" src="{{url('/')}}/images/loading.gif">
                            </div>
                            <div id="updateAvatarSection">
                                <form class="updateAvatarForm">
                                    <input type="file" required name="avatar" id="avatar-input" class="avatar-input" accept=".jpg">
                                </form>
                                <figure>
                                    <i class="nc-icon nc-cloud-upload-94 mx-auto">Yükleee</i>
                                </figure>
                                <img class="avatar" src="{{url('/')}}/images/profileAvatar/{{Auth::user()->avatar}}">
                            </div>
                        </div>
                        <div class="updateProfileImage">
                            <button class="btn btn-sm btn-info" id="updateAvatar" style="text-transform:none" type="button">
                                    <i class="nc-icon nc-cloud-upload-94"></i>
                                    Update Avatar
                            </button>
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-md-8">

            <div class="card card-user col-md-11" id="userProfileCard">
                <div class="card-header">
                    <h5 class="card-title float-left">
                        Your Profile
                    </h5>
                    <button type="submit" class="btn btn-success btn-sm float-right" id="editCancel" style="text-transform:none">Edit Profile</button>
                </div>
                <div class="card-body">
                <div id="statusUpdateProfile" class="d-flex justify-content-center justify-align-center" style="display:none !important">
                    <img class="loading" id="#loading" src="{{url('/')}}/images/loading.gif">
                </div>
                <form class="updateProfile">
                        <div class="form-group row">
                            <label for="name" class="col-form-label col-md-4 my-auto">User Name:</label>
                            <div class="col-md-8">
                                <input type="text" required readonly value="{{Auth::user()->name}}" class="form-control-plaintext" name="name" placeholder="Type User Name" id="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-form-label col-md-4 my-auto">E-mail Adress:</label>
                            <div class="col-md-8">
                                <input type="email" required readonly value="{{Auth::user()->email}}" class="form-control-plaintext" name="email" placeholder="Type a Valid Email" id="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="currentPassword" class="col-form-label col-md-4 my-auto">Current Password:</label>
                            <div class="col-md-8">
                                <input type="password" required readonly autocomplete="off" minlength="6" value="*****************" placeholder="Type a current password" class="form-control-plaintext" name="currentPassword" id="currentPassword">
                            </div>
                        </div>
                        <div class="form-group new-password row" hidden>
                            <label for="new-password" class="col-form-label col-md-4 my-auto">New Password:</label>
                            <div class="col-md-8">
                                <input type="password" required autocomplete="off" minlength="6" placeholder="Type a new password" class="form-control" name="newPassword" id="new-password">
                            </div>
                        </div>

                        <div class="form-group password-confirm row" hidden>
                            <label for="new-password-confirm" class="col-form-label col-md-4 my-auto">Password Confirm:</label>
                            <div class="col-md-8">
                                <input type="password" required autocomplete="off" minlength="6" placeholder="Type new password" class="form-control" name="newPassword_confirmation" id="new-password-confirm">
                            </div>
                        </div>
                        <div class="form-group updateButton row justify-content-center" hidden>
                            <button type="submit" id='updateProfile' class="button btn btn-success" style="text-transform:none;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
       var  formHtmlval;

        function getBackUpdateProfile(){
            var name=$('#name').val();
            var mail=$('#email').val();
            $('#userProfileCard').html(formHtmlval);
            $('#name').attr('value',name);
            $('#email').attr('value',mail);
            $('#navbar-username').text(name);
            formHtmlval= $('#userProfileCard').html();
        }

       $(document).on('click','#editCancel',function() {
           if($('#editCancel').html()=="Edit Profile"){
                formHtmlval= $('#userProfileCard').html();
                $('.form-control-plaintext').removeAttr('readonly');
                $('.form-control-plaintext').removeClass().addClass('form-control');
                $('.new-password, .updateButton, .password-confirm').attr("hidden",false);
                $(this).text('Cancel');
                $('#currentPassword').val('');
                $(this).toggleClass('btn-success btn-danger');
           }
           else{
               $('#userProfileCard').html(formHtmlval);
           }
       });

        $(document).on('click','#updateProfile', function(e){
            e.preventDefault();
            var updateProfileForm=document.getElementsByClassName('updateProfile');
            var isFormValid=updateProfileForm[0].checkValidity();
            var newPassword=$('#new-password').val();
            var passwordConfirm=$('#new-password-confirm').val();
            if(newPassword!=passwordConfirm){
                $('.new-password, .password-confirm').addClass('has-danger');
                $('#new-password, #password-confirm').addClass('form-control-danger');
                document.getElementById('new-password').setCustomValidity("Passwords Don't Match");
                isFormValid=false;
            }
            else{
                document.getElementById('new-password').setCustomValidity('');
            }
            if(isFormValid){
                $.ajax({
                    url:"{{route('user.update', Auth::id())}}",
                    type:'put',
                    dataType:'JSON',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:$('.updateProfile').serializeArray(),
                    beforeSend:function() {
                        $('#statusUpdateProfile').css('display','');
                        $('.updateProfile').hide(100);
                    },
                    success:function(result) {
                        getBackUpdateProfile();
                    },
                    error:function(result) {
                        var $data=jQuery.parseJSON(result.responseText);
                        if (result.status=='401'){
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: $data.message,
                            });
                            getBackUpdateProfile();
                        }
                        else{
                            var $errors='';
                            Object.keys($data.errors).forEach(key => {
                                $data.errors[key].forEach(errorMessage => {
                                    $errors+=errorMessage+'<br>';
                                });
                            });
                            swal({
                                type: 'error',
                                title: $data.message,
                                html:$errors
                            });
                            getBackUpdateProfile();
                        }
                    }
                });
            }
            updateProfileForm[0].reportValidity();
        });

        <!--/*Update Avatar Button Events */-->
        $(document).on('click','#updateAvatar',function () {
            var updateAvatarForm=document.getElementsByClassName('updateAvatarForm');
            var isFormValid=updateAvatarForm[0].checkValidity();
            console.log(isFormValid);

            if (isFormValid) {
                $.ajax({
                    url:"{{route('user.updateAvatar',Auth::id())}}",
                    type:'POST',
                    dataType:'JSON',
                    contentType: false,
			        processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:$('.updateAvatarForm').serializeArray(),
                    beforeSend:function() {
                        $('#statusUpdateAvatar').css('display','');
                        $('#updateAvatarSection').hide(100);
                    },
                    success:function() {
                        $('.statusUpdateAvatar').hide();
                    },
                    error:function(result) {
                        var $data=jQuery.parseJSON(result.responseText);
                        var $errors='';

                        Object.keys($data.errors).forEach(key => {
                            $data.errors[key].forEach(errorMessage => {
                                $errors+=errorMessage+'<br>';
                            });
                        });""

                        $('#userProfileCard').html(formHtmlval);
                        swal({
                            type: 'error',
                            title: $data.message,
                            html:$errors
                        });
                    }
                });
                updateAvatarForm[0].reportValidity();
            }
        });
    });
</script>
@endsection
