objFunctions = {
    data:{
        
    }
};

$(document).ready(function(){
    if($("#fk_institute").get(0).tagName == 'INPUT'){
        lib.data.instituteData($('#fk_institute').val());
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
$(document).on('keydown','#grades,#groups',function(e){
    var c = String.fromCharCode(e.which);
    if(c=='e' || c=='E'){
        value = ($(this).val()).replace(c,'');
        $(this).val(value);
    }
});

$(document).on('click','#btn_save',function(){
    var id = ($("#fk_institute").get(0).tagName == 'INPUT') ? $("#fk_institute").val() : $("#fk_institute :selected").val();
    $('#frm_grados_grupos').attr('action',host+'/grades-groups/'+id);
    $('#btn_send').trigger('click');
});