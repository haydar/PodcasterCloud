<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<style>
    body, html {height: 100% !important;}
</style>

<body>

    <div class="container h-100">
        <div class="row align-items-center">
            <div class="col-md-4">
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    <div class="card card-login">
                        <div class="card-header ">
                            <div class="card-header ">
                                <h3 class="header text-center">Login</h3>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="First Name...">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-key-25"></i>
                                    </span>
                                </div>
                                <input type="password" placeholder="Password" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="" checked="">
                                        <span class="form-check-sign"></span> Subscribe to newsletter
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <a href="#pablo" class="btn btn-danger btn-block btn-fill btn-round mb-3">Get Started</a><br>
                            <a href="http://">Forgetten Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <footer><p>deneme</p></footer>
    </div>
</body>

</html>