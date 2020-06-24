objFunctions = {
    data: {
        selectsCombination: function () {
            var
                institute = null,
                shift = null,
                teacher = null,
                classname = null;

            if ($('#fk_institute').get(0).tagName == 'INPUT') institute = $('#fk_institute').val();
            else if ($('#fk_institute').get(0).tagName == 'SELECT') institute = $('#fk_institute :selected').val();

            if ($('#shift').get(0).tagName == 'INPUT') shift = $('#shift').val();
            else if ($('#shift').get(0).tagName == 'SELECT') shift = $('#shift :selected').val();

            if ($('#fk_teacher').get(0).tagName == 'INPUT') teacher = $('#fk_teacher').val();
            else if ($('#fk_teacher').get(0).tagName == 'SELECT') teacher = $('#fk_teacher :selected').val();

            if ($('#fk_class').get(0).tagName == 'INPUT') classname = $('#fk_class').val();
            else if ($('#fk_class').get(0).tagName == 'SELECT') classname = $('#fk_class :selected').val();

            $('#fk_class > option').hide();
            $('#fk_class > option[data-institute="' + institute + '"][data-shift="' + shift + '"][data-teacher="' + teacher + '"]').show();
            $('#fk_class > option[value=""]').show();

            if($('#mode').val()=='E'){
                $('#fk_institute').val($('#hdn_institute').val());
                $('#fk_teacher').val($('#hdn_teacher').val());
                $('#shift').val($('#hdn_shift').val());
                $('#fk_class').val($('#hdn_class').val());

                if($('#file_path').val()==''){
                    setTimeout(function(){$('.filename').text('No se cargó archivo');},500);
                }
            }
        }
    }
};

$(document).ready(function () {
    switch ($('#mode').val()) {
        case 'C':
        case 'E':
            if ($('#fk_institute').length > 0) {
                if ($('#fk_institute').get(0).tagName == 'INPUT') {
                    objFunctions.data.selectsCombination();

                }
                else if ($('#fk_institute').get(0).tagName == 'SELECT') {
                    if ($('#mode').val() == 'E') {
                        objFunctions.data.selectsCombination();
                    }
                }
            }
            break;
    }
});


$(document).on('change', '#fk_institute', function () {
    objFunctions.data.selectsCombination();
});
$(document).on('change', '#shift', function () {
    objFunctions.data.selectsCombination();
});
$(document).on('change', '#fk_teacher', function () {
    objFunctions.data.selectsCombination();
});