<div class="form-group row font-verdana-bg">
    <div class="col-md-12">
        {{ $user->name }}
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-12">
        LISTA DE ROLES
    </div>
</div>
<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    @foreach ($roles as $datos)
        <div class="form-group row">
            <div class="col-md-4 pr-1 font-verdana-bg">
                <label for="roles_id" class="d-inline">
                    <input type="checkbox" name="roles[]" value="{{ $datos->id }}"  {{ $user->hasAnyRole($datos->id) ? 'checked' : '' }} class="mr-1">
                    {{ $datos->name }}
                </label>
            </div>
        </div>
    @endforeach
</form>