@extends('custom.layouts.master')
@section('content')
<div class="row justify-content-center mx-auto h-100">
    <div class="card transparent my-auto col-md-10">
        <div class="card-header bg-transparent text-center text-success ">
            <h5>Create Podcast</h5>
        </div>
        <div class="card-body text-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('podcast.store')}}"  id="create-podcast" class="pb-0" method="post" enctype="multipart/form-data">
                @csrf
                <section id="stepOne">
                    <section class="float-left pr-4 col-md-6">
                        <div class="form-group row">
                            <label for="name" >Podcast Name</label>
                            <input type="text" required name="name" class="form-control" name="form-control" value="{{ old('name') }}" id="name" placeholder="Podcast Name">
                        </div>
                        <div class="form-group row">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" required name="subtitle" class="form-control" name="form-control" value="{{ old('subtitle') }}" id="subtitle" placeholder="Podcast Subtitle">
                        </div>
                        <div class="form-group row">
                            <label for="description">Description</label>
                            <textarea name="description" required name="description" class="form-control"  placeholder="Tell about your podcast..." id="description" cols="30" rows="5">
                                {{ old('description') }}
                            </textarea>
                        </div>
                    </section>
                    <section class="float-right col-md-6">
                        <div class="form-group row">
                            <label for="language">Language</label>
                            <select data-placeholder="Choose Podcast Language..." required name="language" class="form-control" id="language">
                                <option value="" disabled selected>Select Your Brodcast Language</option>
                                <option value="AF">Afrikanns</option>
                                <option value="SQ">Albanian</option>
                                <option value="AR">Arabic</option>
                                <option value="HY">Armenian</option>
                                <option value="EU">Basque</option>
                                <option value="BN">Bengali</option>
                                <option value="BG">Bulgarian</option>
                                <option value="CA">Catalan</option>
                                <option value="KM">Cambodian</option>
                                <option value="ZH">Chinese (Mandarin)</option>
                                <option value="HR">Croation</option>
                                <option value="CS">Czech</option>
                                <option value="DA">Danish</option>
                                <option value="NL">Dutch</option>
                                <option value="EN">English</option>
                                <option value="ET">Estonian</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finnish</option>
                                <option value="FR">French</option>
                                <option value="KA">Georgian</option>
                                <option value="DE">German</option>
                                <option value="EL">Greek</option>
                                <option value="GU">Gujarati</option>
                                <option value="HE">Hebrew</option>
                                <option value="HI">Hindi</option>
                                <option value="HU">Hungarian</option>
                                <option value="IS">Icelandic</option>
                                <option value="ID">Indonesian</option>
                                <option value="GA">Irish</option>
                                <option value="IT">Italian</option>
                                <option value="JA">Japanese</option>
                                <option value="JW">Javanese</option>
                                <option value="KO">Korean</option>
                                <option value="LA">Latin</option>
                                <option value="LV">Latvian</option>
                                <option value="LT">Lithuanian</option>
                                <option value="MK">Macedonian</option>
                                <option value="MS">Malay</option>
                                <option value="ML">Malayalam</option>
                                <option value="MT">Maltese</option>
                                <option value="MI">Maori</option>
                                <option value="MR">Marathi</option>
                                <option value="MN">Mongolian</option>
                                <option value="NE">Nepali</option>
                                <option value="NO">Norwegian</option>
                                <option value="FA">Persian</option>
                                <option value="PL">Polish</option>
                                <option value="PT">Portuguese</option>
                                <option value="PA">Punjabi</option>
                                <option value="QU">Quechua</option>
                                <option value="RO">Romanian</option>
                                <option value="RU">Russian</option>
                                <option value="SM">Samoan</option>
                                <option value="SR">Serbian</option>
                                <option value="SK">Slovak</option>
                                <option value="SL">Slovenian</option>
                                <option value="ES">Spanish</option>
                                <option value="SW">Swahili</option>
                                <option value="SV">Swedish </option>
                                <option value="TA">Tamil</option>
                                <option value="TT">Tatar</option>
                                <option value="TE">Telugu</option>
                                <option value="TH">Thai</option>
                                <option value="BO">Tibetan</option>
                                <option value="TO">Tonga</option>
                                <option value="TR">Turkish</option>
                                <option value="UK">Ukranian</option>
                                <option value="UR">Urdu</option>
                                <option value="UZ">Uzbek</option>
                                <option value="VI">Vietnamese</option>
                                <option value="CY">Welsh</option>
                                <option value="XH">Xhosa</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="podcast_category">Podcast Category</label>
                            <select required name="category" id="podcast-category" value="{{ old('category') }}" class="form-control">
                                    <option value="" @if(old('category') == "" ? 'selected' : '')@endif disabled>Select Your Category</option>
                                    <option value="arts" @if(old('category') == "arts" ? 'selected' : '')@endif >Arts</option>
                                    <option value="business" @if(old('category') == "business" ? 'selected' : '')@endif >Business</option>
                                    <option value="comedy" @if(old('category') == "comedy" ? 'selected' : '')@endif >Comedy</option>
                                    <option value="education" @if(old('category') == "education" ? 'selected' : '')@endif >Education</option>
                                    <option value="games_hobbies" @if(old('category') == "games_hobbies" ? 'selected' : '')@endif >Games &amp; Hobbies</option>
                                    <option value="government_organizations" @if(old('government_organizations') == "business" ? 'selected' : '')@endif >Government &amp; Organizations</option>
                                    <option value="health" @if(old('category') == "health" ? 'selected' : '')@endif >Health</option>
                                    <option value="kids_family" @if(old('category') == "kids_family" ? 'selected' : '')@endif >Kids &amp; Family</option>
                                    <option value="miscellaneous" @if(old('category') == "miscellaneous" ? 'selected' : '')@endif >Miscellaneous</option>
                                    <option value="music" @if(old('category') == "music" ? 'selected' : '')@endif >Music</option>
                                    <option value="news_politics" @if(old('category') == "news_politics" ? 'selected' : '')@endif >News &amp; Politics</option>
                                    <option value="religion_spirituality" @if(old('category') == "religion_spirituality" ? 'selected' : '')@endif >Religion &amp; Spirituality</option>
                                    <option value="science_medicine" @if(old('category') == "science_medicine" ? 'selected' : '')@endif >Science &amp; Medicine</option>
                                    <option value="society_culture" @if(old('category') == "society_culture" ? 'selected' : '')@endif >Society &amp; Culture</option>
                                    <option value="sports_recreation" @if(old('category') == "sports_recreation" ? 'selected' : '')@endif >Sports &amp; Recreation</option>
                                    <option value="technology" @if(old('category') == "technology" ? 'selected' : '')@endif >Technology</option>
                                    <option value="tv_film" @if(old('category') == "tv_film" ? 'selected' : '')@endif >TV &amp; Film</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="website">Website</label>
                            <input type="url" name="website" placeholder="http://example.com" value="{{ old('website') }}" class="form-control" id="website">
                        </div>
                        <div class="form-group row">
                            <label for="artwork-image">Artwork Image</label>
                            <input type="file" required accept=".jpg,.gif,.png,.jpeg,.gif,.svg" value="{{ old('name') }}" name="artworkImage" class="form-control-file"  id="artwork-image">
                        </div>
                        <div class="form-group row float-right">
                            <button id="next" type="submit" class="btn btn-success col-sm-12 btn-sm-block pull-right">Next <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </section>
                </section>
                </section>
                <section id="stepTwo" style="display:none;">
                    <div class="form-group row">
                            <label for="author-name">Podcast Author</label>
                            <input type="text" required name="authorName" placeholder="Author Name" value="{{ old('name') }}" class="form-control" id="author-name">
                    </div>
                    <p>This section is optional, If you are not using iTunes, but if you are using iTunes at present,
                        you should fill all fields, because iTunes needs more pieces of information.</p>
                    <div class="form-group row">
                        <label for="itunes">iTunes Email Adress</label>
                        <input type="email" name="itunesEmail" placeholder="iTunes Email" class="form-control" id="itunes">
                    </div>
                    <div class="form-group row">
                            <label for="itunes-summary">iTunes Summary</label>
                            <textarea name="itunes-summary" name="itunesSummary" class="form-control" placeholder="Tell about your podcast..." id="itunes-summary" cols="30" rows="3"></textarea>
                    </div>
                    <div class="form-group row float-right">
                        <button type="button" id="back" class="btn btn-success mr-2"><i class="fas fa-undo"></i> Back</button>
                        <button type="submit" id="create" class="btn btn-success"><span class="fas fa-check"></span> Create Podcast</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#next').click(function (e) {
        if(document.querySelectorAll("#stepOne *:valid").length>7===true){
            e.preventDefault();
            $("#stepOne").hide(1000);
            $("#stepTwo").show(1000);
        }
    });

    $('#back').click(function () {
        $("#stepTwo").hide(1000);
        $("#stepOne").show(1000);
    });
</script>
@endsection
