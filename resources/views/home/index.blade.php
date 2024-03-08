@extends('layouts.dashboard')
@section('content')
<div class="form-group row">
    @if (isset($empresa))
        <div class="col-md-12 text-center">
            <img src="{{ url($empresa->url_cover) }}" alt="{{ $empresa->url_cover }}" class="imagen-callejxn">
        </div>
    @else
        <div class="col-md-12 text-center">
            <img src="/images/pi-resto.jpeg" alt="pi-resto" class="imagen-pi-resto">
        </div>
    @endif
</div>
@endsection