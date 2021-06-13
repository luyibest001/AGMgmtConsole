@include('shared.header')
<head>
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
    <script src="https://cdn.rawgit.com/kimmobrunfeldt/progressbar.js/0.7.4/dist/progressbar.js"></script>
</head>
<div id="app">
    <dashboard-component></dashboard-component>
</div>
<!--<a href="{{ URL::to('logout') }}">Logout</a>-->
@include('shared.footer')
