<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welkom bij Wiped</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/layout/bootstrap/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/layout/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/layout/plugins/iCheck/square/blue.css">
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      body.login-page
      {
        background: #ffffff url(/custom/image/mixfinity.jpg) no-repeat bottom center !important ;
        background-size: cover;
        background-attachment: fixed;
      }

      .login-box{
        border: 1px solid #808080;
        background-color: rgba(0, 0, 0, 0.8);
        margin-top: 350px;
      }

      .login-box-body{
        background-color: transparent;
        color: #ffffff;
      }

      .login-box-body a{
        color: #ffffff;
      }

      .login-logo{
            font-size: 35px;
            color: #ffffff;
        text-align: center;
        margin-bottom: 25px;
        font-weight: 300;
        padding-top: 16px;
      }

      .login-logo a{
        color: #ffffff;
      }

      .form-control{
        background-color: transparent;
        border: none;
        border-bottom: 3px solid #808080;
        color: #ffffff;
      }
      .form-control::-webkit-input-placeholder { /* WebKit, Blink, Edge */
          color:    #ffffff;
      }
      .form-control:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
         color:    #ffffff;
         opacity:  1;
      }
      .form-control::-moz-placeholder { /* Mozilla Firefox 19+ */
         color:    #ffffff;
         opacity:  1;
      }
      .form-control:-ms-input-placeholder { /* Internet Explorer 10-11 */
         color:    #ffffff;
      }
     .form-control:placeholder-shown { /* Standard (https://drafts.csswg.org/selectors-4/#placeholder) */
        color:    #ffffff;
      }
    </style>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/"><b>Wiped</b></a>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg">Vul uw gegevens in om in te loggen</p>
        <?php if($usererror){ ?>
        <p class="text-danger">Gebruikersnaam of wachtwoord incorrect</p>
        <?php } ?>
        <form method="post">

          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="Gebruikersnaam">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password"  placeholder="Wachtwoord">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <a href="#" onClick="javascript: alert('Bamihap! Vraag even of iemand je wachtwoord wilt resetten :)');">Ik ben mijn wachtwoord vergeten</a>
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-success btn-block btn-flat">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <script src="/layout/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/layout/bootstrap/js/bootstrap.min.js"></script>
    <script src="/layout/plugins/iCheck/icheck.min.js"></script>
   
  </body>
</html>
