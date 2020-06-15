<div class="row">
    @if(Auth::user()->fk_role == 1)
    <div class="col-12">
        <br>
        <h3><small>Datos de la institución</small></h3>
        <hr>
    </div>
    <div class="col-12">
        <small><span class="text-danger">* Seleccione un instituto para crear un nuevo usuario y su expediente</span></small>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="state">Estados</label>
            <select class="form-control" id="state" autofocus>
                <option value="" disabled selected>Seleccione uno</option>
                @foreach($states as $s)
                <option value="{{$s->id}}">{{$s->estado}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="county">Municipios</label>
            <select class="form-control" id="county">
                <option value="" disabled selected>Seleccione uno</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="fk_institute">Instituto</label>
            <select name="fk_institute" id="fk_institute" class="form-control" required>
                <option value="" disabled selected>Seleccione uno</option>
            </select>
        </div>
    </div>
    @else
    <div class="col-12">
        <br>
        <h4>Instituto: {{$institute->name}}</h4>
        <input type="hidden" name="fk_institute" id="fk_institute" value="{{Auth::user()->fk_institute}}">
    </div>
    @endif
    <div class="col-12">
        <hr>
    </div>
</div>