objFunctions = {
    data:{
        
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



$(document).on('click','#btn_email_student',function(){
    lib.data.userByEmail($('#email_student').val(),5);
});
$(document).on('change','#chk_password_student',function(){
    var password = '<div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password_student" name="password[]" class="form-control" placeholder="Contraseña" title="Contraseña" required></div></div><div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password2_student" name="password2[]" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required></div></div><div class="col-12 col-sm-2"><button type="button" class="btn btn-danger" id="btn_cancel_password_student">Cancelar</button></div>';

    if($(this).is(':checked'))
        $('#password_container_student').html(password);
    else
        $('#password_container_student').empty();
});
$(document).on('click','#btn_cancel_password_student',function(){
    $('#chk_password_student').trigger('click');
});



$(document).on('click','#btn_email_parent',function(){
    lib.data.userByEmail($('#email_parent').val(),4);
});
$(document).on('change','#chk_password_parent',function(){
    var password = '<div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password_parent" name="password[]" class="form-control" placeholder="Contraseña" title="Contraseña" required></div></div><div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password2_parent" name="password2[]" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required></div></div><div class="col-12 col-sm-2"><button type="button" class="btn btn-danger" id="btn_cancel_password_parent">Cancelar</button></div>';

    if($(this).is(':checked'))
        $('#password_container_parent').html(password);
    else
        $('#password_container_parent').empty();
});

$(document).on('click','#btn_cancel_password_parent',function(){
    $('#chk_password_parent').trigger('click');
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