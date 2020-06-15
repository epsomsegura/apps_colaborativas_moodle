<div class="row">
    @if(Auth::user()->fk_role == 1)
    <div class="col-12">
        <small><span class="text-danger">* Seleccione un instituto para crear un nuevo usuario y su expediente</span></small>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="state">Estados</label>
            <select class="form-control" id="state">
                <option value="" disabled selected>Seleccione uno</option>
                @foreach($s as $s)
                @if($s->id == $idEst)
                <option value="{{$s->id}}" selected>{{$s->estado}}</option>
                @else
                <option value="{{$s->id}}">{{$s->estado}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="county">Municipios</label>
            <select class="form-control" id="county">
                <option value="" disabled>Seleccione uno</option>
                @foreach($m as $m)
                @if($m->id == $idMun)
                <option value="{{$m->id}}" selected>{{$m->municipio}}</option>
                @else
                <option value="{{$m->id}}">{{$m->municipio}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="fk_institute">Instituto</label>
            <select name="fk_institute" id="fk_institute" class="form-control" required>
                <option value="" disabled>Seleccione uno</option>
                @foreach($ins as $i)
                @if($i->id == $u->fk_institute)
                <option value="{{$i->id}}" selected>{{$i->name}}</option>
                @else
                <option value="{{$i->id}}">{{$i->name}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    @else
    <div class="col-12">
        <br>
        <h4><small>Instituto: {{$institute->name}}</small></h4>
        <input type="hidden" name="fk_institute" id="fk_institute" value="{{Auth::user()->fk_institute}}">
    </div>
    @endif
    <div class="col-12">
        <hr>
    </div>
</div>