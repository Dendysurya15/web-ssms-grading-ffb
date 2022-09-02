<?php
 session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GRADING AI DASHBOARD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/CBI-logo.png') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">



    <!--download-->
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">

    <!--download-->
    <script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css" />

    <!--download-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}" />
    <!--download-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}" />


    <style type="text/css">
        .center {
            margin: auto;
            height: 500px;
            width: 70%;
            padding: 10px;
            text-align: center;
        }

        .tengah {
            vertical-align: middle;
        }

        .hijau {
            background-color: #00621A;
            color: white;
        }

        .biru {
            background-color: #001494;
            color: white;
        }

        .merah {
            background-color: red;
            color: red;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav" style="width: 100%">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item  d-sm-inline-block">
                    <a class="nav-link">Selamat datang !</a>
                </li>
                <li class="nav-item dropdown ml-auto">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> {{Auth::user()->name}}</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{asset('profile')}}" class="dropdown-item"> <i class="nav-icon fa fa-user"></i> <span
                                class="ml-2"> Edit
                                Profile</span>
                        </a>
                        <a href="{{ asset('/logout') }}" class="dropdown-item"> <i
                                class="nav-icon fa fa-sign-out-alt"></i><span class="ml-2"> Log Out</span></a>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="{{ asset('/') }}" class="brand-link">
                <img src="{{ asset('img/CBI-logo.png') }}" alt="Covid Tracker"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Grading TBS SKM</span>
            </a>
            <div class="sidebar">
                <nav class="" style="height: 100%">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false" style="height: 100%">
                        <!-- USER LAB -->

                        <!-- TABEL -->
                        <li class="nav-item">
                            <a href="{{ asset('/dashboard') }}" class="nav-link">
                                <i class="nav-icon fa fa-chart-line"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ asset('/grafik') }}" class="nav-link">
                                <i class="nav-icon fa fa-chart-pie"></i>
                                <p>
                                    Grafik Grading TBS
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/tabel') }}" class="nav-link">
                                <i class="nav-icon fa fa-table"></i>
                                <p>
                                    Tabel Grading
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/foto') }}" class="nav-link">
                                <i class="nav-icon fa fa-image"></i>
                                <p>
                                    Foto FFB
                                </p>
                            </a>
                        </li>
                        <li class="nav-item fixed-bottom mb-3" heig style="position: absolute;">
                            <a href="{{ asset('/logout') }}" class="nav-link ">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>