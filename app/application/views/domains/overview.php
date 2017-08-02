<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Ontwikkeldomeinen
            <small>overzicht</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-chrome"></i> Home</a></li>
            <li class="active">Domeinen</li>
          </ol>
        </section>

        <section class="content links">

          <div class="row">
          
          <?php foreach($list as $k => $v){ ?>
    

            <div class="col-md-3 col-sm-6 box-item ">
              <a class = " " target = "_blank" href = "http://<?php echo $v ?>">
                <?php echo $k ?>
              </a>
            </div>
          <?php } ?>
          </div>
        </section>
    </div>

    <style>
      .box-item:hover{
        cursor: pointer;
      }

      .box-item a{
        display: block;
      }

      .box-item{
        padding-left: 0 !important;
        padding-right: 0 !important;
      }

      .box-body{
        text-transform: capitalize;
      }

    @font-face {
      font-family: 'intro_light';
      src: url("/custom/fonts/intro_light.woff2") format("woff2"), url("fonts/intro_light.woff") format("woff"), url("fonts/intro_light.ttf") format("truetype"); }
    @font-face {
      font-family: 'intro_book';
      src: url("/custom/fonts/intro_book.woff2") format("woff2"), url("fonts/intro_book.woff") format("woff"), url("fonts/intro_book.ttf") format("truetype"); }
    @font-face {
      font-family: 'intro_bold';
      src: url("/custom/fonts/intro_bold.woff2") format("woff2"), url("fonts/intro_bold.woff") format("woff"), url("fonts/intro_bold.ttf") format("truetype"); }

    .links  h1{
      background: #cccccc;
        background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJod…hlaWdodD0iMTAxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
        background: -moz-radial-gradient(center, ellipse cover, #cccccc 0%, white 83%);
        background: -webkit-gradient(radial, center center, 0px, center center, 83%, color-stop(0%, #cccccc), color-stop(83%, white));
        background: -webkit-radial-gradient(center, ellipse cover, #cccccc 0%, white 83%);
        background: -o-radial-gradient(center, ellipse cover, #cccccc 0%, white 83%);
        background: -ms-radial-gradient(center, ellipse cover, #cccccc 0%, white 83%);
        background: radial-gradient(ellipse at center, #cccccc 34%, white 83%, #fff 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cccccc', endColorstr='#ffffff',GradientType=1 );
        text-align: center;
        font-family: intro_bold;
        color: #000000;
        font-size: 45px;
        height: 140px;
        line-height: 140px;
        margin: 0 -15px;
        background-size: 100% 717%;
        background-position: 50% 0;
        background-repeat: no-repeat;
    }

    .links{
      font-family: intro_light;
      overflow:hidden;

    }
    
    .links a{     
      color:#fff;
      background: #2dfffd;
        background: -moz-linear-gradient(-45deg, #2dfffd 0%, #f8ae48 20%, #ee5b30 40%, #222d32 60%, #222d32 60%, #37444a 99%);
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #2dfffd), color-stop(20%, #f8ae48), color-stop(40%, #ee5b30), color-stop(60%, #222d32), color-stop(60%, #222d32), color-stop(99%, #37444a));
        background: -webkit-linear-gradient(-45deg, #2dfffd 0%, #f8ae48 20%, #ee5b30 40%, #222d32 60%, #222d32 60%, #37444a 99%);
        background: -o-linear-gradient(-45deg, #2dfffd 0%, #f8ae48 20%, #ee5b30 40%, #222d32 60%, #222d32 60%, #37444a 99%);
        background: -ms-linear-gradient(-45deg, #2dfffd 0%, #f8ae48 20%, #ee5b30 40%, #222d32 60%, #222d32 60%, #37444a 99%);
        background: linear-gradient(135deg, #2dfffd 0%, #f8ae48 20%, #ee5b30 40%, #222d32 60%, #222d32 60%, #37444a 99%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2dfffd', endColorstr='#000000',GradientType=1 );
        background-size: 250% 250%;
        background-position: 100% 100%;
        background-repeat: no-repeat;
        transition: .8s all;
        position: relative;
        border: 1px solid #888;
        text-align: center;
        text-decoration: none!important;
        font-size: 22px;
        height: 150px;
        padding: 3% 10px;
        word-break: break-all;
        vertical-align: middle;
        margin-right: -1px;
        margin-bottom: -1px;
        line-height: 120px;

    }

    .links a:first-letter{
      text-transform: uppercase;
    }

    .links a:hover{
      background-position: 0 0;
      color:#000;
      text-decoration: none!important;
    }

  </style>