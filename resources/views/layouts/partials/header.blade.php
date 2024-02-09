<div class="form-group row">
    <div class="col-md-12">
        <div class="card-header header">
            <div class="row">
                <div class="col-md-8">
                    <b><i class="{{ $icono }}"></i> {{ $empresa->nombre_comercial }} - {{ $header }}</b>
                </div>
                <div class="col-md-4 text-right">
                    @if (auth()->user()->id != 1)
                        <img src="{{ url($empresa->url_logo) }}" alt="{{ $empresa->url_logo }}" class="imagen-menu">
                    @else
                        <img src="/images/pi-resto.jpeg" alt="pi-resto" class="imagen-menu">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>