@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    @php($idPadre = $_REQUEST['padre'])
	@include('functions.father')
    @include('functions.father-headboard')
    @include('functions.index-modules')
@endsection