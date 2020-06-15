




$(document).on('click','.btn_delete',function(){
    $id=$(this).data('id');
    $name = $(this).closest('tr').find('td:eq(0)').text();

    $('#frm_delete').attr('action',host+"/profiles/"+$id);
    $('#txt_name').html($name);
})