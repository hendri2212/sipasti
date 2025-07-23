<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIPASTI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        .side-img {
            background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-md-6 p-0 d-none d-md-block">
                <div class="side-img"></div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center text-center">
                <form action="{{ url('/') }}" method="get" style="background: rgba(255,255,255,0.9); max-width: 400px; width: 100%;">
                    <span class="fs-1 text-success fw-bold">SIPASTI</span>
                    <div class="form-floating mb-2">
                        <input class="form-control form-control-lg rounded-0" type="text" id="username" name="username" placeholder="User name">
                        <label for="username">User name</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input class="form-control form-control-lg rounded-0" type="password" id="password" name="password" placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg btn-success rounded-0">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>