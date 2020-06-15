objFunctions = {
    data:{
        
    },
    validations:{
        saveForm: function(){
            var validate = false;

            var v1 = ($('#password').val() == $('#password2').val());

            if(v1){
                validate=true;
            }
            else
                alert('Las contraseñas no coinciden');
            
            return validate;
        }
    }
};


$(document).on('change','#state',function(){
    lib.data.countiesByState($(this,':selected').val());
});
$(document).on('change','#county',function(){
    lib.data.institutesByCounty($(this,':selected').val());
});

$(document).on('click','#btn_save',function(){
    if(objFunctions.validations.saveForm()){
        $('#btn_send').trigger('click');
    }
});



$(document).on('click','.btn_delete',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();
    
    $('#frm_delete').attr('action',host+"/users/"+$id);
    $('#txt_name').html($name);
});
$(document).on('click','.btn_disable',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();
    
    $('#frm_disable').attr('action',host+"/users/softdelete/"+$id);
    $('#txt_name_d').html($name);
});
$(document).on('click','.btn_enable',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();
    
    $('#frm_enable').attr('action',host+"/users/softdelete/"+$id);
    $('#txt_name_e').html($name);
});




$(document).on('change','#chk_password',function(){
    var password = '<div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" title="Contraseña" required></div></div><div class="col-12 col-sm-5"><div class="form-group"><input type="password" id="password2" name="password2" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required></div></div><div class="col-12 col-sm-2"><button type="button" class="btn btn-danger" id="btn_cancel_password">Cancelar</button></div>';

    if($(this).is(':checked'))
        $('#password_container').html(password);
    else
        $('#password_container').empty();
});

$(document).on('click','#btn_cancel_password',function(){
    $('#chk_password').trigger('click');
});