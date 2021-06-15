<head>
    <link href="/css/login.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/typicons/2.0.9/typicons.min.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body ></body>
<div class="animated bounceInDown" id="login">
<!--    <div class="container">
        <span class="error animated tada" id="msg"></span>
        <form name="loginForm" class="box" onsubmit="return checkStuff()" action="" method="POST">
            <h4>Accent Group Admin <span>Dashboard</span></h4>
            <h5>Sign in to your account.</h5>
            <input type="text" name="email" placeholder="Email" autocomplete="off">
            <i class="typcn typcn-eye" id="eye"></i>
            <input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">
            <input type="submit" value="Sign in" class="btn1">
        </form>
    </div>-->
    <login-component></login-component>

</div>

@include('shared.footer')
