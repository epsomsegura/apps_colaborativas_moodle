@extends('layouts.app')

@section('title','Calificaciones')
@section('content')

@csrf
<div class="row">
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Materia</th>
                    <th>Estudiante</th>
                    <th>Entregable</th>
                    <th>Respuesta</th>
                    <th>Retroalimentación</th>
                    <th>Estatus</th>
                    <th>Calificación</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ast as $i)
                <tr>
                    <td>
                        <h5>{{$i->ast_a->instruction}}</h5>
                        <span>{{$i->ast_a->request}}</span>
                    </td>
                    <td>{{$i->ast_a->a_ic->ic_c->classname}}</td>
                    <td>{{$i->ast_st->se_stud->name}}</td>
                    <td>
                        @if($i->file_response != null)
                            <small><a href="{{url($i->file_response)}}" target_="BLANK" class="text-primary">Descargar archivo</a></small>
                        @else
                        <small>{{'No cargó archivo'}}</small>
                        @endif
                    </td>
                    <td>{{($i->response!=null) ? $i->response : 'Sin respuesta'}}</td>
                    <td>
                        <textarea rows="5" class="form-control feedback" maxlength="2000" {{($i->status==2) ? 'readonly':''}}">{{($i->feedback!=null) ? $i->feedback : 'Sin retroalimentación'}}</textarea>
                    </td>
                    <td>
                        @switch($i->status)
                        @case(0)
                        {{'Sin revisar'}}
                        @break
                        @case(1)
                        {{'Cargado por el estudiante'}}
                        @break
                        @case(2)
                        {{'Revisado'}}
                        @break
                        @endswitch
                    </td>
                    <td>
                        <input type="text" maxlength="2" pattern="^0*(?:[1-9][0-9]?|100)$" class="form-control text-center" value="{{$i->score}}" {{($i->status==2) ? 'readonly':''}}>
                    </td>
                    <td class="text-center">
                        @if($i->status == 0)
                        <a href="#" class="text-primary btn_score" data-id="{{Crypt::encrypt($i->id)}}"><i class="fas fa-save"></i></a>
                        @elseif($i->status == 1)
                        <a href="#" class="text-primary btn_score" data-id="{{Crypt::encrypt($i->id)}}"><i class="fas fa-save"></i></a>
                        @elseif($i->status == 2)
                        {{'-'}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
            <a href="{{url('/activities')}}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>

<script>
    $(document).on('click','.btn_score',function(){
        var params ={
            _token : $('input[name="_token"]').val(),
            feedback : $(this).closest('tr').find('td>textarea').val(),
            score : $(this).parent().prev().find('input').val()
        };

        $.post(host+'/activities/scores/'+$(this).data('id'),params)
        .done(function(resp){
            if(resp == 'OK'){
                alert('La calificación se registró correctamente');
                window.location.reload();
            }
            else{
                alert('Ocurrión un error');
            }
        })
        .function(function(error){alert(error);});
    });
</script>

@stop