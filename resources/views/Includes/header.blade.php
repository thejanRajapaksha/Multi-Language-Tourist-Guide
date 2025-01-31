<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="{{ asset('manifest.json') }}">

        <title>MULTI-LANGUAGE-TOURIST-GUIDE</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <!-- fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Righteous&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Icons CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/header/favicon.png') }}"/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">



        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        
        <!-- Vendor CSS Files -->
        <!-- <link href="{{ asset('aos/aos.css') }}" rel="stylesheet" /> -->
        <link href="{{ asset('fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('swiper/swiper-bundle.min.css') }}" rel="stylesheet" />
        <!-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" /> -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet" />

        <!-- @livewireStyles -->
    </head>
    <body class="antialiased">