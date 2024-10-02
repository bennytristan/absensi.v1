@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Absensi GPS</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 16px;
        }

        #map {
            height: 265px;

        }

        .jam-digital-malasngoding {

            background-color: #27272783;
            position: absolute;
            top: 70px;
            right: 15px;
            z-index: 9999;
            width: 140px;
            border-radius: 10px;
            padding: 5px;
        }

        .jam-digital-malasngoding p {
            color: #fff;
            font-size: 13px;
            text-align: right;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
    <div class="row" style="margin-top:60px">
        <div class="col">
            <div class="alert alert-warning" style="text-align: center">
                <p>
                    Maaf Anda tidak memiliki jadwal kerja hari ini..! Silahkan Hubungi HRD
                </p>
            </div>
        </div>
    </div>
@endsection
