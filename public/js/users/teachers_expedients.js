objFunctions = {
    data:{
        profileSuggestion: function(word){
            $.getJSON(host+'/global/profileSuggestion/'+word)
            .done(function(resp){
                $('#suggestions').empty();
                objBadges = '';
                if(resp.length>0){
                    $.each(resp,function(i,val){
                        objBadges += '<span class="suggestion" data-id="'+val.id+'"><span class="badge badge-primary">'+val.profile+'</span></span>';
                    });
                }
                else{
                    $('#description_container').slideDown();
                    objBadges += '<span class="save_word"><span class="badge badge-secondary">Guardar perfil</span></span>';
                }
                $('#suggestions').html(objBadges);
            })
            .fail(function(error){alert(error)});
        },
        saveProfileSuggestion: function(profile,description){
            var params = {
                _token: $('input[name="_token"]').val(),
                profile: profile,
                description: description
            };
            $.post(host+'/global/saveProfileSuggestion',params)
            .done(function(resp){
                alert("Perfil agregado al catálogo");
                $('#fk_profile').val(resp.id);
                $('#profile').val(resp.profile);
                $('#suggestions').empty();
                $('#description_container').slideUp();
            })
            .fail(function(error){alert(error);});
        }
    }
};


$(document).ready(function(){
    switch($('#mode').val()){
        case 'C':
        case 'E':
            if($('#fk_institute').length>0){
                if($('#fk_institute').get(0).tagName == 'INPUT'){
                    lib.data.instituteData($('#fk_institute').val());
                }
                else if($('#fk_institute').get(0).tagName == 'SELECT'){
                    if($('#mode').val()=='E')
                        lib.data.instituteData($('#fk_institute :selected').val());
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
    lib.data.instituteData($(this,':selected').val());
});



$(document).on('click','#btn_email_teacher',function(){
    lib.data.userByEmail($('#email_teacher').val(),3);
});
$(document).on('change','#chk_password_teacher',function(){
    var password = '<div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password_teacher" name="password[]" class="form-control" placeholder="Contraseña" title="Contraseña" required></div></div><div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password2_teacher" name="password2[]" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required></div></div><div class="col-12 col-sm-2"><button type="button" class="btn btn-danger" id="btn_cancel_password_teacher">Cancelar</button></div>';

    if($(this).is(':checked'))
        $('#password_container_teacher').html(password);
    else
        $('#password_container_teacher').empty();
});
$(document).on('click','#btn_cancel_password_teacher',function(){
    $('#chk_password_teacher').trigger('click');
});



$(document).on('input','#profile',function(){
    if($(this).val()!=''){
        objFunctions.data.profileSuggestion($(this).val());
    }
    else{
        $('#suggestions').empty();
        $('#description_container').slideUp();
    }
});
$(document).on('click','.save_word',function(){
    if($('#profile').val()!='' || $('#profile'.val()!=null))
        if($('#description').val()!='')
            objFunctions.data.saveProfileSuggestion($('#profile').val(),$('#description').val());
        else alert("Ingrese la descripción del perfil por favor");
    else alert("Ingrese el nombre del perfil por favor");
    
});
$(document).on('click','.suggestion',function(){
    $('#fk_profile').val($(this).data('id'));
    $('#profile').val($(this).text());
    $('#suggestions').empty();
    $('#description_container').slideUp();
});




$(document).on('click','#btn_save',function(){
    $('#group_class').val();
    $('#btn_send').trigger('click');
});




$(document).on('click','.btn_disable',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();
    
    $('#frm_disable').attr('action',host+"/users/students/"+$id);
    $('#txt_name').html($name);
});

$(document).on('click','.btn_enable',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();
    
    $('#frm_enable').attr('action',host+"/users/students/"+$id);
    $('#txt_name').html($name);
});