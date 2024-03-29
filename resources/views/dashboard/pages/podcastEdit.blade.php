@extends('dashboard.layouts.master')
@section('title',$podcast->name)
@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 id="podcastName">{{$podcast->name}}</h3>
            <a class="text-bold" for="feedUrl">Your XML Feed : </a><a href="http://podcastercloud.com/feeds/{{$podcast->slug}}"> http://podcastercloud.com/feeds/{{$podcast->slug}}</a>
        </div>
        <div class="card-header">
            <form action="{{route('podcast.update',$podcast->slug)}}"  id="editPodcastForm" class="pb-0" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <section class="float-left pr-4 col-md-6">
                    <div class="form-group row">
                        <label for="name" >Podcast Name</label>
                        <input type="text" required name="name" class="form-control" name="form-control" value="{{$podcast->name}}" id="name" placeholder="Podcast Name">
                    </div>
                    <div class="form-group row">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" required name="subtitle" class="form-control" name="form-control" value="{{$podcast->subtitle}}" id="subtitle" placeholder="Podcast Subtitle">
                    </div>
                    <div class="form-group row">
                        <label for="description">Description</label>
                        <textarea name="description" required name="description" class="form-control"  placeholder="Tell about your podcast..." id="description" cols="30" rows="5">{{$podcast->description}}</textarea>
                    </div>
                    <div class="form-group row">
                        <label for="language">Language</label>
                        <select data-placeholder="Choose Podcast Language..." required name="language"  class="form-control" id="language">
                            <option value="" disabled selected>Select Your Brodcast Language</option>
                            <option value="AF" {{$podcast->language == "AF" ? 'selected':''}}>Afrikanns</option>
                            <option value="SQ" {{$podcast->language == "SQ" ? 'selected':''}}>Albanian</option>
                            <option value="AR" {{$podcast->language == "AR" ? 'selected':''}}>Arabic</option>
                            <option value="HY" {{$podcast->language == "HY" ? 'selected':''}}>Armenian</option>
                            <option value="EU" {{$podcast->language == "EU" ? 'selected':''}}>Basque</option>
                            <option value="BN" {{$podcast->language == "BN" ? 'selected':''}}>Bengali</option>
                            <option value="BG" {{$podcast->language == "BG" ? 'selected':''}}>Bulgarian</option>
                            <option value="CA" {{$podcast->language == "CA" ? 'selected':''}}>Catalan</option>
                            <option value="KM" {{$podcast->language == "KM" ? 'selected':''}}>Cambodian</option>
                            <option value="ZH" {{$podcast->language == "ZH" ? 'selected':''}}>Chinese (Mandarin)</option>
                            <option value="HR" {{$podcast->language == "HR" ? 'selected':''}}>Croation</option>
                            <option value="CS" {{$podcast->language == "CS" ? 'selected':''}}>Czech</option>
                            <option value="DA" {{$podcast->language == "DA" ? 'selected':''}}>Danish</option>
                            <option value="NL" {{$podcast->language == "NL" ? 'selected':''}}>Dutch</option>
                            <option value="EN" {{$podcast->language == "EN" ? 'selected':''}}>English</option>
                            <option value="ET" {{$podcast->language == "ET" ? 'selected':''}}>Estonian</option>
                            <option value="FJ" {{$podcast->language == "FJ" ? 'selected':''}}>Fiji</option>
                            <option value="FI" {{$podcast->language == "FI" ? 'selected':''}}>Finnish</option>
                            <option value="FR" {{$podcast->language == "FR" ? 'selected':''}}>French</option>
                            <option value="KA" {{$podcast->language == "KA" ? 'selected':''}}>Georgian</option>
                            <option value="DE" {{$podcast->language == "DE" ? 'selected':''}}>German</option>
                            <option value="EL" {{$podcast->language == "EL" ? 'selected':''}}>Greek</option>
                            <option value="GU" {{$podcast->language == "GU" ? 'selected':''}}>Gujarati</option>
                            <option value="HE" {{$podcast->language == "HE" ? 'selected':''}}>Hebrew</option>
                            <option value="HI" {{$podcast->language == "HI" ? 'selected':''}}>Hindi</option>
                            <option value="HU" {{$podcast->language == "HU" ? 'selected':''}}>Hungarian</option>
                            <option value="IS" {{$podcast->language == "IS" ? 'selected':''}}>Icelandic</option>
                            <option value="ID" {{$podcast->language == "ID" ? 'selected':''}}>Indonesian</option>
                            <option value="GA" {{$podcast->language == "GA" ? 'selected':''}}>Irish</option>
                            <option value="IT" {{$podcast->language == "IT" ? 'selected':''}}>Italian</option>
                            <option value="JA" {{$podcast->language == "JA" ? 'selected':''}}>Japanese</option>
                            <option value="JW" {{$podcast->language == "JW" ? 'selected':''}}>Javanese</option>
                            <option value="KO" {{$podcast->language == "KO" ? 'selected':''}}>Korean</option>
                            <option value="LA" {{$podcast->language == "LA" ? 'selected':''}}>Latin</option>
                            <option value="LV" {{$podcast->language == "LV" ? 'selected':''}}>Latvian</option>
                            <option value="LT" {{$podcast->language == "LT" ? 'selected':''}}>Lithuanian</option>
                            <option value="MK" {{$podcast->language == "MK" ? 'selected':''}}>Macedonian</option>
                            <option value="MS" {{$podcast->language == "MS" ? 'selected':''}}>Malay</option>
                            <option value="ML" {{$podcast->language == "ML" ? 'selected':''}}>Malayalam</option>
                            <option value="MT" {{$podcast->language == "MT" ? 'selected':''}}>Maltese</option>
                            <option value="MI" {{$podcast->language == "MI" ? 'selected':''}}>Maori</option>
                            <option value="MR" {{$podcast->language == "MR" ? 'selected':''}}>Marathi</option>
                            <option value="MN" {{$podcast->language == "MN" ? 'selected':''}}>Mongolian</option>
                            <option value="NE" {{$podcast->language == "NE" ? 'selected':''}}>Nepali</option>
                            <option value="NO" {{$podcast->language == "NO" ? 'selected':''}}>Norwegian</option>
                            <option value="FA" {{$podcast->language == "FA" ? 'selected':''}}>Persian</option>
                            <option value="PL" {{$podcast->language == "PL" ? 'selected':''}}>Polish</option>
                            <option value="PT" {{$podcast->language == "PT" ? 'selected':''}}>Portuguese</option>
                            <option value="PA" {{$podcast->language == "PA" ? 'selected':''}}>Punjabi</option>
                            <option value="QU" {{$podcast->language == "QU" ? 'selected':''}}>Quechua</option>
                            <option value="RO" {{$podcast->language == "RO" ? 'selected':''}}>Romanian</option>
                            <option value="RU" {{$podcast->language == "RU" ? 'selected':''}}>Russian</option>
                            <option value="SM" {{$podcast->language == "SM" ? 'selected':''}}>Samoan</option>
                            <option value="SR" {{$podcast->language == "SR" ? 'selected':''}}>Serbian</option>
                            <option value="SK" {{$podcast->language == "SK" ? 'selected':''}}>Slovak</option>
                            <option value="SL" {{$podcast->language == "SL" ? 'selected':''}}>Slovenian</option>
                            <option value="ES" {{$podcast->language == "ES" ? 'selected':''}}>Spanish</option>
                            <option value="SW" {{$podcast->language == "SW" ? 'selected':''}}>Swahili</option>
                            <option value="SV" {{$podcast->language == "SV" ? 'selected':''}}>Swedish </option>
                            <option value="TA" {{$podcast->language == "TA" ? 'selected':''}}>Tamil</option>
                            <option value="TT" {{$podcast->language == "TT" ? 'selected':''}}>Tatar</option>
                            <option value="TE" {{$podcast->language == "TE" ? 'selected':''}}>Telugu</option>
                            <option value="TH" {{$podcast->language == "TH" ? 'selected':''}}>Thai</option>
                            <option value="BO" {{$podcast->language == "BO" ? 'selected':''}}>Tibetan</option>
                            <option value="TO" {{$podcast->language == "TO" ? 'selected':''}}>Tonga</option>
                            <option value="TR" {{$podcast->language == "TR" ? 'selected':''}}>Turkish</option>
                            <option value="UK" {{$podcast->language == "UK" ? 'selected':''}}>Ukranian</option>
                            <option value="UR" {{$podcast->language == "UR" ? 'selected':''}}>Urdu</option>
                            <option value="UZ" {{$podcast->language == "UZ" ? 'selected':''}}>Uzbek</option>
                            <option value="VI" {{$podcast->language == "VI" ? 'selected':''}}>Vietnamese</option>
                            <option value="CY" {{$podcast->language == "CY" ? 'selected':''}}>Welsh</option>
                            <option value="XH" {{$podcast->language == "XH" ? 'selected':''}}>Xhosa</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="author-name">Podcast Author</label>
                        <input type="text" required name="authorName" placeholder="Author Name" value="{{$podcast->authorName}}" class="form-control" id="author-name">
                    </div>
                    <div class="form-group row">
                        <label for="podcast_category">Podcast Category</label>
                        <select required name="category" id="podcast-category" value="{{ old('category') }}" class="form-control">
                            <option value="" @if(old('category') == "" ? 'selected' : '')@endif disabled>Select Your Category</option>
                            <option value="Arts" @if(old('category') == "Arts" ? 'selected' : '')@endif >Arts</option>
                            <option value="Business" @if(old('category') == "Business" ? 'selected' : '')@endif >Business</option>
                            <option value="Comedy" @if(old('category') == "Comedy" ? 'selected' : '')@endif >Comedy</option>
                            <option value="Education" @if(old('category') == "Education" ? 'selected' : '')@endif >Education</option>
                            <option value="Games & Hobbies" @if(old('category') == "Games & Hobbies" ? 'selected' : '')@endif >Games &amp; Hobbies</option>
                            <option value="Government & Organizations" @if(old('category') == "Government & Organizations" ? 'selected' : '')@endif >Government &amp; Organizations</option>
                            <option value="Health" @if(old('category') == "Health" ? 'selected' : '')@endif >Health</option>
                            <option value="Kids & Family" @if(old('category') == "Kids & Family" ? 'selected' : '')@endif >Kids &amp; Family</option>
                            <option value="Miscellaneous" @if(old('category') == "Miscellaneous" ? 'selected' : '')@endif >Miscellaneous</option>
                            <option value="Music" @if(old('category') == "Music" ? 'selected' : '')@endif >Music</option>
                            <option value="News & Politics" @if(old('category') == "News & Politics" ? 'selected' : '')@endif >News &amp; Politics</option>
                            <option value="Religion & Spirituality" @if(old('category') == "Religion & Spirituality" ? 'selected' : '')@endif >Religion &amp; Spirituality</option>
                            <option value="Science & Medicine" @if(old('category') == "Science & Medicine" ? 'selected' : '')@endif >Science &amp; Medicine</option>
                            <option value="Society & Culture" @if(old('category') == "Society & Culture" ? 'selected' : '')@endif >Society &amp; Culture</option>
                            <option value="Sports & Recreation" @if(old('category') == "Sports & Recreation" ? 'selected' : '')@endif >Sports &amp; Recreation</option>
                            <option value="Technology" @if(old('category') == "Technology" ? 'selected' : '')@endif >Technology</option>
                            <option value="TV & Film" @if(old('category') == "TV & Film" ? 'selected' : '')@endif >TV &amp; Film</option>
                        </select>
                    </div>
                </section>
                <section class="float-right col-md-6">
                    <div class="form-group row">
                        <label for="website">Website</label>
                        <input type="url" name="website" required placeholder="http://example.com" value="{{ $podcast->website }}" class="form-control" id="website">
                    </div>
                    <div class="form-group row">
                        <label for="artwork-image">Artwork Image</label>
                    </div>
                    <div class="form-group row justify-content-center">
                        <img  height="50%" width="50%" id="podcastImage"  src="{{Storage::disk('doSpaces')->url('uploads/podcastImages/'.$podcast->artworkImage)}}">
                    </div>
                    <div class="form-group row justify-content-center">
                        <button  class="btn btn-info ml-0">Browse
                                <input type="file" accept=".jpg,.gif,.png,.jpeg,.gif,.svg" name="artworkImage" class="form-control-file"  id="artwork-image">
                        </button>
                    </div>
                </section>
                <section class="col-md-12 d-inline-block">
                    <div class="form-group row">
                            <a>This section is optional, If you are not using iTunes, but if you are using iTunes at present,
                                    you should fill all fields, because iTunes needs more pieces of information.</a>
                    </div>
                    <div class="form-group row">
                        <label for="itunes">iTunes Email Adress</label>
                        <input type="email" name="itunesEmail" placeholder="iTunes Email" value="{{$podcast->itunesEmail}}" class="form-control" id="itunes">
                    </div>
                    <div class="form-group row">
                        <label for="itunes-summary">iTunes Summary</label>
                        <textarea name="itunesSummary" class="form-control" placeholder="Tell about your podcast..." id="itunes-summary" cols="30" rows="3">{{$podcast->itunesSummary}}</textarea>
                    </div>
                    <div class="form-group row float-right">
                        <button type="submit" id="updatePodcast" class="btn btn-success"><span class="fa fa-check"></span> Update Podcast</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.5/sweetalert2.all.js" integrity="sha256-+yrurPEYDIh9PES+m128Vc0a49Csb6lx0lSzXjX62HQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        //Update Podcast Button
        var updateEpisodeButton = document.getElementById('updatePodcast');

        updateEpisodeButton.onclick = function(e) {

            var formData = new FormData(document.getElementById('editPodcastForm'));

            var isFormValid = document.getElementById('editPodcastForm').checkValidity();
            if (isFormValid) {
                e.preventDefault();
                $.ajax({
                    url:"{{route('podcast.update',$podcast->slug)}}",
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
                                title: 'Podcast Updated!',
                        });

                        document.getElementById('podcastName').innerHTML=result.podcastName;
                        document.getElementById('navbar-podcastName').innerHTML=result.podcastName;
                        document.getElementById('podcastImage').src=result.imagePath;
                        document.getElementById('artwork-image').value="";
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

