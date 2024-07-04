<div class="row">
    <div class="col-md-12 font-roboto-15 text-center">
        <b>
            <i class="{{ $icono }} fa-beat"></i>
            {{ $header }}
            @if (isset($empresa))
                - {{ $empresa->nombre_comercial }}
            @endif
        </b>
    </div>
</div>
<hr class="custom-hr">
