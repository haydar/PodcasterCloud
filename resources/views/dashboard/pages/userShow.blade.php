@extends('dashboard.layouts.master')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-user">
                    <div class="card-body">
                        <div class="image">
                        </div>
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="{{url('/')}}/images/profileAvatar/{{Auth::user()->avatar}}">
                            </a>
                            <div class="updateProfileImage">
                                <button class="btn btn-sm btn-info" style="text-transform:none" type="button">
                                        <i class="nc-icon nc-cloud-upload-94"></i>
                                        Change Avatar
                                </button>
                            </div>
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
                <div class="status d-flex justify-content-center justify-align-center" style="display:none !important">
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
<script>
    $(document).ready(function() {
       var  formHtmlval;
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
            var isFormValid=document.forms[1].checkValidity();
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
                        $('.status').css('display','');
                        $('.updateProfile').hide(100);
                    },
                    success:function(result) {
                        var name=$('#name').val();
                        var mail=$('#email').val();
                        $('#userProfileCard').html(formHtmlval);
                        $('#name').attr('value',name);
                        $('#email').attr('value',mail);
                        $('#navbar-username').text(name);
                        formHtmlval= $('#userProfileCard').html();
                    },
                    error:function(result) {
                        alert("We're having a problem right now and please try it later.");
                    }
                });
            }
            document.forms[1].reportValidity();
        });
    });
</script>
@endsection
