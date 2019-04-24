<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Laracasts')</title>
    <!-- google font -->
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- custom css -->
{{--    <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}">--}}
    <!-- font awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- tailwind cdn -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap (MDB)-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
    {{--bulma--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.css" />
    <link rel="stylesheet" href="/css/app.css" type="text/css"/>

    <style>
        .is-comlete {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
<div class="container">
    <ul>
        <li>
            <a href="/">Home</a>
        </li>
        <li>
            <a href="/contact">
                Contact Us
            </a>
        </li>
        <li>
            <a href="/about">
                About Us
            </a>
        </li>
        <li>
            <a href="/projects">
                Projects
            </a>
        </li>
    </ul>
    @yield('content')
</div>


<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>
