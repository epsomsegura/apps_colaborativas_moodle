lib = {
    data: {
        countiesByState: function (idState) {
            $.getJSON(host + '/global/countiesByState/' + idState)
                .done(function (resp) {
                    $('#county').empty();
                    objCounties = '<option value="" disabled selected>Seleccione uno</option>';
                    $.each(resp, function (i, val) {
                        objCounties += '<option value="' + val.id + '">' + val.municipio + '</>';
                    });
                    $('#county').append(objCounties).focus();
                })
                .fail(function (error) { alert(error) });

        },
        institutesByCounty: function (idCounty) {
            $.getJSON(host + '/global/institutesByCounty/' + idCounty)
                .done(function (resp) {
                    $('#fk_institute').empty();
                    objCounties = '<option value="" disabled selected>Seleccione uno</option>';
                    $.each(resp, function (i, val) {
                        objCounties += '<option value="' + val.id + '">' + val.name + '</>';
                    });
                    $('#fk_institute').append(objCounties).focus();
                })
                .fail(function (error) { alert(error) });
        },
        instituteData: function (idInstitute) {
            $.getJSON(host + '/global/instituteData/' + idInstitute)
                .done(function (resp) {
                    var shift = null;
                    $('#shift,#hdn_shift').val(resp.instituteData.shift);
                    $('#grade_val').val(resp.instituteData.grades);
                    $('#group_class_val').val(resp.instituteData.groups);

                    $('#lbl_shift').parent().find('div').remove();

                    objShift = '<div>';
                    if (resp.instituteData.shift == 'A') {
                        objShift += '<select id="shift" name="shift" class="form-control" required>';
                        objShift += '<option value="" disabled selected>Seleccione uno</option>';
                        objShift += '<option value="M">Matutino</option>';
                        objShift += '<option value="V">Vespertino</option>';
                        objShift += '</select>';
                    }
                    else {
                        var t_shift = ((resp.instituteData.shift == 'M') ? 'Matutino' : ((resp.instituteData.shift == 'V') ? 'Vespertino' : ''));
                        objShift += '<input type="text" id="t_shift" class="form-control" placeholder="Turno" title ="Turno" value="' + t_shift + '" readonly>';
                        objShift += '<input type="hidden" id="shift" name="shift" value="' + resp.instituteData.shift + '" required>';
                    }
                    objShift += '</div>';

                    $('#lbl_shift').parent().append(objShift);



                    switch (resp.instituteData.shift) {
                        case 'M': shift = 'Matutino'; break;
                        case 'V': shift = 'Vespertino'; break;
                        case 'A': shift = 'Mixto'; break;
                    }
                    $('#t_shift').val(shift);
                    $('#grade').empty();
                    $('#group_class').empty();

                    objGrades = '<option value="" disabled selected>Seleccione uno</option>';
                    for (var i = 1; i <= resp.instituteData.grades; i++)objGrades += '<option value="' + i + '">' + i + '</option>';
                    $('#grade').html(objGrades);

                    objGroups = '<option value="" disabled selected>Seleccione uno</option>';
                    $.each(resp.groups, function (i, val) { objGroups += '<option value="' + (i + 1) + '">' + val + '</>'; });
                    $('#group_class').html(objGroups);

                    if ($('#mode').val() == 'E') {
                        $('#shift').val($('#hdn_shift').val());
                        $('#grade,#grades').val(parseInt($('#grade_val').val()));
                        $('#group_class,#groups').val(parseInt($('#group_class_val').val()));
                    }
                })
                .fail(function (error) { alert(error) });
        },
        userByEmail: function (email, role) {
            var params = { email: email };

            $.getJSON(host + '/global/userByEmail/' + role, params)
                .done(function (resp) {
                    var sRole = '', sMsg = '';
                    switch (role) {
                        case 3:
                            sRole = 'teacher';
                            sMsg = 'Este correo electrónico ya fue registrado ¿Desea obtener los datos para verificar la información?';
                            break;
                        case 4:
                            sRole = 'parent';
                            sMsg = 'Este correo electrónico ya fue registrado ¿Desea obtener los datos para verificar la información?';
                            break;
                        case 5:
                            sRole = 'student';
                            sMsg = 'Este correo electrónico ya fue registrado ¿Desea obtener los datos para verificar la información (Aceptar) o desea buscar en todos los registros (Cancelar)?'
                            break;
                    }

                    if (resp.email != null) {
                        var r = confirm(sMsg);
                        if (r) {
                            $('#email_' + sRole).val(resp.email);
                            $('#name_' + sRole).val(resp.name);
                            $('#password_' + sRole).val('');
                            $('#pwds_container').empty();
                        }
                        else {
                            window.location.href = host + '/users/' + sRole + 's#' + email;
                        }
                    }
                    else {
                        alert('Este correo electrónico aún no ha sido registrado, puede continuar el llenado del formulario');
                    }
                })
                .fail(function (error) { alert(error) });
        }
    },
    settings: {
        dRPick:{
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        dtEs: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando del _START_ al _END_ - _TOTAL_ ",
            "sInfoEmpty": "Mostrando del 0 al 0 - Total: 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
    },
    onLoad: function (){ 
        // FILES
        if ($('input[type="file"]').length > 0) {
            $.each($('input[type="file"]'), function (i, val) {
                objNext = '<div class="col-12">';
                objNext += '<small>Nombre del archivo: <span class="filename">Aún no carga su archivo</span></small>';
                objNext += '</div>';
                $(this).parent().parent().append(objNext);
            });
        }
        // LOADER
        $('.loader-container').fadeOut(1000);

        // ALERTS
        if ($('.alert-container').length > 0) {
            // setTimeout(function(){$('.alert-container').fadeOut()},5000);
        }

        // DATATABLES
        $('table').DataTable({
            "language": lib.settings.dtEs,
            "scrollX": true,
            "order": [[0, "asc"]],
            "lengthMenu": [5, 10, 15],
            "autoWidth": false,
        }).columns.adjust().draw();

        $('table').attr('style', '100% !important');

        // TEXTAREA
        if ($('textarea').length > 0) {
            $.each($('textarea'), function (i, val) {
                var size = $(this).attr('maxlength');
                objNext = '<div class="text-size-content text-right">';
                objNext += '<small><span class="text-size">0</span>/' + size + '</small>';
                objNext += '</div>';
                $(this).parent().append(objNext);
            });
        }

        // DATETIMERANGEPICKER
        moment.locale('es');
        $('.dates').daterangepicker({
            timePicker: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
              }
        });
    }
}


// ON READY
$(document).ready(function () {
    lib.onLoad();
});

// AJAX CONFIG
$.ajaxSetup({
    beforeSend: function () {
        $('.loader-container').css({ 'display': 'flex' });
    },
    success: function () {
        $('.loader-container').fadeOut();
    },
    error: function () {
        alert("Ocurrió un error inesperado, por favor contacte al soporte técnico para mayor información");
    }
});

// WINDOW RESIZE TRICKS
$(window).on('resize', function () {
    $('table').DataTable().columns.adjust().draw();
});

// TEXTAREA
$(document).on('input', 'textarea', function () {
    var sizeContent = ($(this).val()).length
    $(this).next().find('small').find('.text-size').html(sizeContent);
});

// INPUT FILE
$(document).on('change','input[type="file"]',function(){
    var file=$(this)[0].files[0];
    var types=['application/zip','application/pdf','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','text/plain','image/jpeg','image/png'];
    if(types.indexOf(file.type)>-1){
        $(this).parent().parent().find('small').find('span').html(file.name);
    }
    else{
        alert('No es un archivo compatible, intente con los formatos específicos');
        $(this).val();
        $(this).parent().parent().find('small').find('span').html('Aún no carga su archivo');
    }
});