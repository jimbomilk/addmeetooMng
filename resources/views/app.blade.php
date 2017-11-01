<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADDMEETOO | Dashboard2</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link href="{{ asset('/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="{{ asset('/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="{{ asset('/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/css/template.css') }}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- WYSIWYG Editor -->
    <script src="{{ asset('/plugins/tinymce/js/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
    <script>
        var tm_fonts = "Andale Mono=andale mono,times;"+
                "Arial=arial,helvetica,sans-serif;"+
                "Arial Black=arial black,avant garde;"+
                "Book Antiqua=book_antiquaregular,palatino;"+
                "Corda Light=CordaLight,sans-serif;"+
                "Courier New=courier_newregular,courier;"+
                "Flexo Caps=FlexoCapsDEMORegular;"+
                "Lucida Console=lucida_consoleregular,courier;"+
                "Georgia=georgia,palatino;"+
                "Helvetica=helvetica;"+
                "Impact=impactregular,chicago;"+
                "Museo Slab=MuseoSlab500Regular,sans-serif;"+
                "Museo Sans=MuseoSans500Regular,sans-serif;"+
                "Oblik Bold=OblikBoldRegular;"+
                "Sofia Pro Light=SofiaProLightRegular;"+
                "Symbol=webfontregular;"+
                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
                "Terminal=terminal,monaco;"+
                "Tikal Sans Medium=TikalSansMediumMedium;"+
                "Times New Roman=times new roman,times;"+
                "Trebuchet MS=trebuchet ms,geneva;"+
                "Verdana=verdana,geneva;"+
                "Webdings=webdings;"+
                "Wingdings=wingdings,zapf dingbats"+
                "Aclonica=Aclonica, sans-serif;"+
                "Michroma=Michroma;"+
                "Paytone One=Paytone One, sans-serif;"+
                "Andalus=andalusregular, sans-serif;"+
                "Arabic Style=b_arabic_styleregular, sans-serif;"+
                "Andalus=andalusregular, sans-serif;"+
                "KACST_1=kacstoneregular, sans-serif;"+
                "Mothanna=mothannaregular, sans-serif;"+
                "Nastaliq=irannastaliqregular, sans-serif;"+
                "Samman=sammanregular;";
        tinymce.init({
            selector: '#mytextarea',
            menubar: '',
            language: 'es',
            branding: false,
            statusbar: false,
            plugins: 'lists,link,image,preview,media,visualchars,table,textcolor,emoticons',
            relative_urls: true,
            remove_script_host: true,
            protocol: 'https',
            toolbar: 'fontselect fontsizeselect | forecolor backcolor | emoticons | ' +
            'bold italic underline | link image | alignleft aligncenter alignright alignjustify | bullist numlist | preview',
            font_formats: tm_fonts,
            media_live_embeds: true,
            fontsize_formats: "36pt 46pt 56pt 66pt 76pt 86pt 96pt 106pt",
            height:500

        });
    </script>

</head>
@if ($login_user->is('admin'))
<body class="skin-blue">
@else
<body class="skin-red">
@endif




@yield('content')


<!-- jQuery 2.1.3 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>



<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>



@yield('scripts')


<!-- Sparkline -->
<script src="{{ asset('/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>


<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('/plugins/morris/morris.min.js') }}" type="text/javascript"></script>

<!-- daterangepicker -->
<script src="{{ asset('/plugins/daterangepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<!-- datepicker -->
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset('/plugins/fastclick/fastclick.min.js') }}"></script>


<!-- AdminLTE App -->
<script src="{{ asset('/dist/js/app.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('/dist/js/global.js') }}" type="text/javascript"></script>




</body>
</html>