@extends('layouts.dashboard')
@section('content')
<br>
    <div class="form-group row">
        @if (count($empresas) > 0)
            @foreach ($empresas as $datos)
                <div class="col-md-12 text-center">
                    <img src="{{ url($datos->url_cover) }}" alt="{{ $datos->url_cover }}" class="imagen-callejxn">
                </div>
            @endforeach
        @else
            <div class="col-md-12 text-center">
                <img src="/images/pi-resto.jpeg" alt="pi-resto" class="imagen-pi-resto">
            </div>
        @endif
    </div>
@endsection