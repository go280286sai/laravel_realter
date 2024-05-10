<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{$title??'Parser'}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- My style CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/my_css.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/blog.css')}}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('assets/plugins/iCheck/all.css')}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker3.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/skins/_all-skins.min.css')}}">
    <!-- Button style-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/app.css'])
    @section('style')
    @show

</head>
<body class="hold-transition skin-red sidebar-collapse">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="{{env('APP_URL')}}" class="logo" title="{{__('messages.ref_to_site')}}">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini "><b>{{env('APP_NAME')}}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{env('APP_NAME')}}</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-fixed-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"
               title="">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu mr-10">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu ">
                        <ul class="dropdown-menu ">
                            <!-- User image -->
                            <li class="user-header">
                                <img
                                    src="{{\Illuminate\Support\Facades\Storage::url($getUser->profile_photo_path)}}"
                                    class="img-circle inline" alt="{{$getUser->name}}">
                                <p>
                                    {{$getUser->name}}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{url('/user/profile')}}"
                                       class="btn btn-default btn-flat">{{__('messages.profile')}}</a>
                                </div>
                                <div class="pull-right">
                                    <form action="{{url('/user/exit')}}" method="get">
                                        <input type="submit" class="btn btn-default btn-flat" name="submit"
                                               value="{{__('messages.logout')}}">
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img
                        src="{{\Illuminate\Support\Facades\Storage::url(\Illuminate\Support\Facades\Auth::user()->profile_photo_path)}}"
                        class="logo_mini" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <li><a href="{{url('/user/dashboard')}}"><i class="fa fa-dashboard"></i>
                        <span>Админ-панель</span></a></li>
                <li><a href="{{url('/user/apartment')}}"><i class="fa fa-sticky-note-o"></i>
                        <span>Недвижимость</span></a>
                </li>
                <li><a href="{{url('/user/client')}}"><i class="fa fa-user-circle"></i>
                        <span>Клиенты</span></a></li>
                <li><a href="{{url('/user/service')}}"><i class="fa fa-user-o"></i> <span>Услуги</span></a>
                </li>
                <li><a href="{{url('/user/documents')}}"><i class="fa fa-sticky-note-o"></i>
                        <span>Заявки</span></a></li>
                <li><a href="{{url('/user/users')}}"><i class="fa fa-users"></i> <span>Пользователи</span></a>
                </li>
                <li><a href="{{url('/user/profile')}}"><i class="fa fa-user-plus"></i>
                        <span>Профиль</span></a></li>
                <li>
                    <a href="{{url('/user/exit')}}"><i class="fa fa-sign-out"></i> <span>Выход</span></a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    @section('text')
    @show
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.7
        </div>
        <strong>Copyright &copy; {{\Carbon\Carbon::now()->format('d M Y')}} <a href="https://astorchak.blogspot.com/"
                                                                               target="_blank">Storchak Aleksander</a>.</strong>
        All rights
        reserved.
    </footer>
    <div class="control-sidebar-bg"></div>
</div>

@vite('resources/js/app.js')

<script src="{{asset('/assets/plugins/jQuery/jquery-3.7.1.min.js')}}"></script>

<script src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/select2.full.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('/assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('/assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/assets/plugins/fastclick/fastclick.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset('/assets/plugins/iCheck/icheck.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets/dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/assets/dist/js/demo.js')}}"></script>
<!-- Plugins for input text -->
<script src="{{asset('/assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/assets/plugins/ckfinder/ckfinder.js')}}"></script>
@section('js')
@show

<script>
    $(document).ready(function () {
        const editor = CKEDITOR.replaceAll();
        CKFinder.setupCKEditor(editor);
    })

</script>
</body>
</html>

