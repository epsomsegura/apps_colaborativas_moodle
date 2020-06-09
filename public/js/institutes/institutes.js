objFunctions = {
    data:{
        zipcode:function(){
            $.getJSON(host+'/global/zipcode_filter/'+$('#zipcode').val())
            .done(function(resp){
                $('#state').val(resp[0].estado);
                $('#county').val(resp[0].municipio);

                objSelect = '<option value="" disabled selected>Seleccione uno</option>';
                $.each(resp,function(i,val){
                    objSelect += '<option value="'+val.asentamiento+'">'+val.asentamiento+'</option>';
                });
                $('#suburb').empty().append(objSelect);
            })
            .fail(function(){
                alert('Atención: El código postal no es válido');
            });
        }
    }
};

$(document).on('blur','#zipcode',function(){
    $('#btn_zipcode').trigger('click');
})

$(document).on('click','#btn_zipcode',function(){
    if($('#zipcode').val()!='')
        objFunctions.data.zipcode();
    else{
        alert('Debes llenar el campo');
        $('#zipcode').focus();
    }
});


$(document).on('click','.btn_delete',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();

    $('#frm_delete').attr('action',host+"/institutes/"+$id);
    $('#txt_name').html($name);
})