<!-- resources/views/layouts/master.blade.php -->
<!doctype html>
<html lang="en">
    <head>
        <title>Transport Bill Management - @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    
        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">
    
        <link rel="icon" href="../assets/images/originals/favicon.png">

        <link rel="stylesheet" href="/assets/css/base.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </head>
    <body>               

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <!--Header START-->
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            {{--  <div class="logo-src"></div>  --}}
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>    <div class="app-header__content">
            <div class="app-header-left">
                <div class="search-wrapper">
                    <div class="input-holder">
                        <input type="text" class="search-input" placeholder="Type to search">
                        <button class="search-icon"><span></span></button>
                    </div>
                    <button class="close"></button>
                </div>
                <ul class="header-megamenu nav">
                    
                </ul>        
            </div>
            <div class="app-header-right">
                <div class="header-dots">
                </div>
                
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <img width="42" class="rounded-circle" src="/assets/images/avatars/default.jpg" alt="">
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-2" style="background-image: url('/assets/images/dropdown-header/city3.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="42" class="rounded-circle"
                                                                     src="/assets/images/avatars/default.jpg"
                                                                     alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">
                                                                    <?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name; ?>
                                                                </div>
                                                                <div class="widget-subheading opacity-8">
                                                                    <?php echo Auth::user()->roles->first()->name; ?>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
                                                                <button class="btn-pill btn-shadow btn-shine btn btn-focus"><a class="text-white" href="/logout">Logout</a>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">                                    
                                    <?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name; ?>
                                </div>
                                <div class="widget-subheading">
                                    <?php echo Auth::user()->roles->first()->name; ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="header-btn-lg">
                </div>        
            </div>
        </div>
    </div>    <!--Header END-->
    
    <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>    
                
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Home</li>
                            <li class="mm-active" >
                                <a href="/dashboard">
                                    <i class="metismenu-icon pe-7s-home"></i>
                                    Dashboard                                    
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Menu</li>
                            
                            <?php 
                                if(Auth::user()->hasRole('superadmin')) {

                                
                            ?>
                            <li class="mm-active" >
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-users"></i>
                                    User Management
                                    
                                </a>
                                <ul>
                                    <li>
                                        <a href="/listuser">
                                            <i class="metismenu-icon">
                                            </i>List User
                                        </a>
                                    </li>

                                    <li>
                                        <a href="/adduser">
                                            <i class="metismenu-icon">
                                            </i>Add User
                                        </a>
                                    </li>
                                                                     
                                </ul>
                            </li>
                            <?php } ?>
                            @if (Auth::user()->hasRole('superadmin'))
                            <li class="mm-active">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-credit"></i>                                    
                                    Project Management
                                    
                                </a>
                                <ul>
                                    <li>
                                        <a href="/listproject">
                                            <i class="metismenu-icon">
                                            </i>List Project
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/addproject">
                                            <i class="metismenu-icon">
                                            </i>Add Project
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            <li class="mm-active">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-credit"></i>
                                    Bill Management
                                    
                                </a>
                                <ul>
                                    <li>
                                        @if (Auth::user()->hasRole('superadmin'))
                                            <a href="/listbilladmin"><i class="metismenu-icon"></i>List Bill</a>
                                            <a href="/addbilladmin"><i class="metismenu-icon"></i>Add Bill</a>                                            
                                        @else
                                            <a href="/listbilluser"><i class="metismenu-icon"></i>List Bill</a>
                                            <a href="/addbill"><i class="metismenu-icon"></i>Add Bill</a>                                            
                                        @endif
                                    </li>                                    
                                </ul>
                            </li>
                            
                            <li class="mm-active">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-note2"></i>
                                    Reports
                                    
                                </a>
                                <ul>
                                    <li>
                                        @if (Auth::user()->hasRole('superadmin'))
                                            <a href="/reports"><i class="metismenu-icon"></i>Reports</a>
                                        @else
                                            <a href="/reportsuser"><i class="metismenu-icon"></i>Reports</a>
                                        @endif
                                        
                                    </li>
                                </ul>
                            </li>
                            
                            @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('accounts'))
                            <li class="mm-active">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-note2"></i>                                    
                                    Management Approval
                                </a>
                                <ul>
                                    <li>
                                        <a href="/monitorbill">
                                            <i class="metismenu-icon">
                                            </i>Approve or Reject
                                        </a>
                                    </li>                                    
                                </ul>
                            </li>
                            @endif

                            <li class="app-sidebar__heading">Exit</li>
                            <li class="mm-active" >
                                <a href="/logout">
                                    <i class="metismenu-icon lnr-exit"></i>
                                    Logout                                    
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>    
            <div class="app-main__outer">
                <div class="app-main__inner">


                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-medal icon-gradient bg-tempting-azure"></i>
                                </div>
                                <div>
                                    
                                    @yield('heading')
                                </div>
                            </div>                                             
                    
                        </div>
                    </div>
                    
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            @if(Session::has('message'))
                                <div class="alert alert-success">
                                    {{Session::get('message')}}
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                </div>
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            
                        </div>
                    </div>
                </div>    
            </div>
    </div>
</div>

<!--SCRIPTS INCLUDES-->

<!--CORE-->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/metismenu"></script>
<script src="/assets/js/scripts-init/app.js"></script>
<script src="/assets/js/scripts-init/demo.js"></script>

<!--CHARTS-->

<!--Apex Charts-->
<script src="/assets/js/vendors/charts/apex-charts.js"></script>

<script src="/assets/js/scripts-init/charts/apex-charts.js"></script>
<script src="/assets/js/scripts-init/charts/apex-series.js"></script>

<!--Sparklines-->
<script src="/assets/js/vendors/charts/charts-sparklines.js"></script>
<script src="/assets/js/scripts-init/charts/charts-sparklines.js"></script>

<!--Chart.js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script src="/assets/js/scripts-init/charts/chartsjs-utils.js"></script>

<!--FORMS-->

<!--Clipboard-->
<script src="/assets/js/vendors/form-components/clipboard.js"></script>
<script src="/assets/js/scripts-init/form-components/clipboard.js"></script>

<!--Datepickers-->
<script src="/assets/js/vendors/form-components/datepicker.js"></script>
<script src="/assets/js/vendors/form-components/daterangepicker.js"></script>
<script src="/assets/js/vendors/form-components/moment.js"></script>
<script src="/assets/js/scripts-init/form-components/datepicker.js"></script>

<!--Multiselect-->
<script src="/assets/js/vendors/form-components/bootstrap-multiselect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="/assets/js/scripts-init/form-components/input-select.js"></script>

<!--Form Validation-->
<script src="/assets/js/vendors/form-components/form-validation.js"></script>
<script src="/assets/js/scripts-init/form-components/form-validation.js"></script>

<!--Form Wizard-->
<script src="/assets/js/vendors/form-components/form-wizard.js"></script>
<script src="/assets/js/scripts-init/form-components/form-wizard.js"></script>

<!--Input Mask-->
<script src="/assets/js/vendors/form-components/input-mask.js"></script>
<script src="/assets/js/scripts-init/form-components/input-mask.js"></script>

<!--RangeSlider-->
<script src="/assets/js/vendors/form-components/wnumb.js"></script>
<script src="/assets/js/vendors/form-components/range-slider.js"></script>
<script src="/assets/js/scripts-init/form-components/range-slider.js"></script>

<!--Textarea Autosize-->
<script src="/assets/js/vendors/form-components/textarea-autosize.js"></script>
<script src="/assets/js/scripts-init/form-components/textarea-autosize.js"></script>

<!--Toggle Switch -->
<script src="/assets/js/vendors/form-components/toggle-switch.js"></script>


<!--COMPONENTS-->

<!--BlockUI -->
<script src="/assets/js/vendors/blockui.js"></script>
<script src="/assets/js/scripts-init/blockui.js"></script>

<!--Calendar -->
<script src="/assets/js/vendors/calendar.js"></script>
<script src="/assets/js/scripts-init/calendar.js"></script>

<!--Slick Carousel -->
<script src="/assets/js/vendors/carousel-slider.js"></script>
<script src="/assets/js/scripts-init/carousel-slider.js"></script>

<!--Circle Progress -->
<script src="/assets/js/vendors/circle-progress.js"></script>
<script src="/assets/js/scripts-init/circle-progress.js"></script>

<!--CountUp -->
<script src="/assets/js/vendors/count-up.js"></script>
<script src="/assets/js/scripts-init/count-up.js"></script>

<!--Cropper -->
<script src="/assets/js/vendors/cropper.js"></script>
<script src="/assets/js/vendors/jquery-cropper.js"></script>
<script src="/assets/js/scripts-init/image-crop.js"></script>

<!--Maps -->
<script src="/assets/js/vendors/gmaps.js"></script>
<script src="/assets/js/vendors/jvectormap.js"></script>
<script src="/assets/js/scripts-init/maps-word-map.js"></script>
<script src="/assets/js/scripts-init/maps.js"></script>

<!--Guided Tours -->
<script src="/assets/js/vendors/guided-tours.js"></script>
<script src="/assets/js/scripts-init/guided-tours.js"></script>

<!--Ladda Loading Buttons -->
<script src="/assets/js/vendors/ladda-loading.js"></script>
<script src="/assets/js/vendors/spin.js"></script>
<script src="/assets/js/scripts-init/ladda-loading.js"></script>

<!--Rating -->
<script src="/assets/js/vendors/rating.js"></script>
<script src="/assets/js/scripts-init/rating.js"></script>

<!--Perfect Scrollbar -->
<script src="/assets/js/vendors/scrollbar.js"></script>
<script src="/assets/js/scripts-init/scrollbar.js"></script>

<!--Toastr-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>
<script src="/assets/js/scripts-init/toastr.js"></script>

<!--SweetAlert2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="/assets/js/scripts-init/sweet-alerts.js"></script>

<!--Tree View -->
<script src="/assets/js/vendors/treeview.js"></script>
<script src="/assets/js/scripts-init/treeview.js"></script>


<!--TABLES -->
<!--DataTables-->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.10.19/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js" crossorigin="anonymous"></script>

<!--Bootstrap Tables-->
<script src="/assets/js/vendors/tables.js"></script>

<!--Tables Init-->
<script src="/assets/js/scripts-init/tables.js"></script>

<script src="/js/custom.js"></script>

    </body>
</html>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}

            <div class="modal-body">
                <p style="text-align: center;">
                    <img id="id_img_file" src="" />
                </p>                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                
            </div>
            
        </div>
    </div>
</div>