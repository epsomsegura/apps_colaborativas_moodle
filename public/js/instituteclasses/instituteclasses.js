objFunctions={
    data:{
        checkGrades: function(idInstitute){
            $.getJSON(host+'/global/instituteData/'+idInstitute)
            .done(function(resp){
                $('#gradesChecklist,#groupsChecklist').empty();

                if(resp!=null){
                    objChecklist = '<label for="">Grados</label>';
                    for(var i=1;i<=resp.instituteData.grades;i++){
                        objChecklist += '<div class="form-check"><input class="form-check-input" type="checkbox" value="'+i+'" id="chk_grades_'+i+'" name="classgrade[]"><label class="form-check-label" for="chk_grades_'+i+'">Grado: '+i+'</label></div>';
                    }
                    $('#gradesChecklist').html(objChecklist);
                    
                    objChecklist = '<label for="">Grupos</label>';
                    for(var i=0;i<resp.groups.length;i++){
                        objChecklist += '<div class="form-check"><input class="form-check-input" type="checkbox" value="'+(i+1)+'" id="chk_groups_'+(i+1)+'" name="classgroup[]"><label class="form-check-label" for="chk_groups_'+(i+1)+'">Grado: '+resp.groups[i]+'</label></div>';
                    }
                    $('#groupsChecklist').html(objChecklist);

                    if($('#mode').val()=='E'){
                        var shift=null;
                        if($('#shift').get(0).tagName=='SELECT') shift =$('#shift :selected') .val();
                        else if($('#shift').get(0).tagName=='INPUT') shift =$('#shift') .val();

                        if($('#fk_institute').get(0).tagName == 'SELECT')
                            objFunctions.data.classGrades(idInstitute,$('#fk_class').val(),shift);
                        else if($('#fk_institute').get(0).tagName == 'INPUT')
                            objFunctions.data.classGrades(idInstitute,$('#fk_class').val(),shift);
                    }
                }
            })
            .fail(function(error){alert(error);});
        },
        classGrades: function(idInstitute, idClass, shift){
            $.getJSON(host+'/global/classGrades/'+idInstitute+'/'+idClass+'/'+shift)
            .done(function(resp){
                if(resp != null){
                    $.each(resp.classgrade,function(i,val){
                        var status = (val.status==1)
                        $('#chk_grades_'+val.classgrade).prop('checked',status);
                    });
                    $.each(resp.classgroup,function(i,val){
                        var status = (val.status==1)
                        $('#chk_groups_'+val.classgroup).prop('checked',status);
                    });
                }
            })
            .fail(function(error){alert(error)});
        },
        classSuggestion: function(word){
            $.getJSON(host+'/global/classSuggestion/'+word)
            .done(function(resp){
                $('#suggestions').empty();
                objBadges = '';
                if(resp.length>0){
                    $.each(resp,function(i,val){
                        objBadges += '<span class="suggestion" data-id="'+val.id+'"><span class="badge badge-primary">'+val.classname+'</span></span>';
                    });
                }
                else{
                    $('#description_container').slideDown();
                    objBadges += '<span class="save_word"><span class="badge badge-secondary">Guardar materia</span></span>';
                }
                $('#suggestions').html(objBadges);
            })
            .fail(function(error){alert(error)});
        },
        saveClassSuggestion: function(classname,description){
            var params = {
                _token: $('input[name="_token"]').val(),
                classname: classname,
                description: description
            };
            $.post(host+'/global/saveClassSuggestion',params)
            .done(function(resp){
                alert("Materia agregada al catálogo");
                $('#fk_class').val(resp.id);
                $('#classname').val(resp.classname);
                $('#suggestions').empty();
                $('#description_container').slideUp();
            })
            .fail(function(error){alert(error);});
        },
        saveTeacherClassAssignment:function(idInstituteClass,$idTeacher){
            var params={_token:$('input[name="_token"]').val()}
            $.post(host+'/institute_classes/assignment/'+idInstituteClass+'/'+$idTeacher,params)
            .done(function(resp){
                if(resp=='OK')
                    window.location.reload();
                else
                    alert('Error al intentar asignar al docente en la materia seleccionada');
            })
            .fail(function(error){alert(error)});
        }
    }
};




$(document).ready(function(){
    switch($('#mode').val()){
        case 'C':
        case 'E':
            if($('#fk_institute').length>0){
                if($('#fk_institute').get(0).tagName == 'INPUT'){
                    objFunctions.data.checkGrades($('#fk_institute').val());
                }
                else if($('#fk_institute').get(0).tagName == 'SELECT'){
                    if($('#mode').val()=='E')
                        objFunctions.data.checkGrades($('#fk_institute :selected').val());
                }
            }
            break;

        case 'R':
            setTimeout(function(){
                var url = window.location.href;
                if(url.indexOf('#') > -1){
                    var email = url.split('#')[1];
                    $('.dataTables_filter input').val(email).trigger($.Event("keyup", { keyCode: 13 }));
                }
            },1000);
            break;
    }
});




$(document).on('change','#state',function(){
    lib.data.countiesByState($(this,':selected').val());
});
$(document).on('change','#county',function(){
    lib.data.institutesByCounty($(this,':selected').val());
});
$(document).on('change','#fk_institute',function(){
    objFunctions.data.checkGrades($(this,':selected').val());
});


$(document).on('input','#classname',function(){
    if($(this).val()!=''){
        objFunctions.data.classSuggestion($(this).val());
    }
    else{
        $('#suggestions').empty();
        $('#description_container').slideUp();
    }
});
$(document).on('click','.save_word',function(){
    if($('#classname').val()!='' || $('#classname'.val()!=null))
        if($('#description').val()!='')
            objFunctions.data.saveClassSuggestion($('#classname').val(),$('#description').val());
        else alert("Ingrese la descripción de la materia por favor");
    else alert("Ingrese el nombre de la materia por favor");
    
});
$(document).on('click','.suggestion',function(){
    $('#fk_class').val($(this).data('id'));
    $('#classname').val($(this).text());
    $('#suggestions').empty();
    $('#description_container').slideUp();
});


$(document).on('click','.btn_delete',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();

    $('#frm_delete').attr('action',host+"/institute_classes/"+$id);
    $('#txt_name').html($name);
})




$(document).on('click','.btn_assign',function(){
    var idInstituteClass=$(this).parent().prev().find('.fk_teacher').data('id');
    var idTeacher=$(this).parent().prev().find('.fk_teacher :selected').val();

    objFunctions.data.saveTeacherClassAssignment(idInstituteClass,idTeacher)

});




$(document).on('click','.btn_list',function(){
    var list = ($(this).data('list'));
    var grade = $(this).data('grade');
    var group = $(this).data('group');
    var classname = $(this).data('classname');

    $('#txt_classname').html(classname);
    $('#txt_grade').html(grade);
    $('#txt_group').html(group);
    objList='';
    $.each(list,function(i,val){
        objList+='<li>'+val.se_stud.name+'</li>';
    });
    $('#studentslist').html(objList);
});