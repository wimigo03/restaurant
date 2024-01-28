<div class="profile">
    @if (isset($empresa))
        <img src="{{ url($empresa->url_logo) }}" alt="{{ $empresa->url_logo }}" class="img-fluid">
        <h3 class="name">{{ $empresa->nombre_comercial }}</h3>
        <span class="country">{{ auth()->user()->cargo_header }}</span>    
    @endif
</div>