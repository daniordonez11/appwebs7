@extends('cabeceras.app')

@section('title', 'Página de Inicio')

@section('content')
    <h1 style="font-weigth: bold; font-size: 64px; text-align: center;">Sobre nosotros</h1>
    <img src="{{ asset('img/jds.png') }}" alt="Logo" style="height: 290px; display: block; margin: 0 auto;">
    <p>Es una empresa que viene iniciando que se dedica a realizar servicios técnicos, como ser mantenimiento y reparación de computadoras, instalación de equipos de seguridad, instalación de redes y telecomunicaciones, sistemas y más.</p>
@endsection