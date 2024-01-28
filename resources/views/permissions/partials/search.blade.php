<div class="form-group row">
    <div class="col-md-5 pr-1 font-verdana-bg">
        <select name="titulo" id="titulo" placeholder="--Seleccionar--" class="form-control select2">
            <option value="">-</option>
            @foreach ($titulos as $titulo)
                <option value="{{ $titulo->title }}"
                    @if($titulo->title == request('titulo'))
                        selected
                    @endif>
                    {{ strtoupper($titulo->title) }}
                </option>
            @endforeach
        </select>
    </div>
</div>  
