<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vida e Saúde - ADRA</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @include('site.header')
    @include('site.banner')
    @include('site.about')
    @include('site.projects', ['projects' => $projects])
    @include('site.form')
    @include('site.footer')
    </body>