var _debug = true;
var ajaxCalls = new Array();
var resultDisplayed = false;

$( document ).ready(function() {
    $("#searchField").first().focus();
});


$('#advanced_link').click(function() {
    $('#advanced_link').addClass("hide");
    $('#row_advanced_search').removeClass("hide");
});

$('#combo_structure').change(function() {
    $('#combo_sous_structure').html('<option value="">Chargement...</option>');
    $.ajax({
            url: 'sous-structure.php',
            data: {struct:  $('#combo_structure').val()}
        })
        .done(function (data) {
            debug("done sous-structure with data: " + data);
            var html = '<option value="">Sous-Structure</option>';
            data.forEach(function(elt) {
                html += '<option value="'+ elt.structure.structId +'">'+ elt.structureLibelle +'</option>';
            });
            $('#combo_sous_structure').html(html);
        })
        .fail(function () {
            debug("error");
        })
        .always(function () {
            debug("complete");
        });
    search();
});

$('#combo_sous_structure').change(function() {
    search();
});



$('#searchField').on('input', function (e) {
    cancelAjaxCalls();
    search();

});

function search() {
    text = $('#searchField').val();
    if (text.length > 2 || $('#combo_structure').val() != '') {
        $("#row_result").html('');
        $("#row_result").addClass("loading");
        var ajaxCall = $.ajax({
                url: 'result.php',
                data: {
                    name: text,
                    struct: $('#combo_structure').val(),
                    sstruct: $('#combo_sous_structure').val()
                }
            })
            .done(function (data) {
                debug("done for: " + text);
                $("#row_result").removeClass("loading");
                $('#row_result').html(data);
            })
            .fail(function () {
                debug("error");
            })
            .always(function () {
                debug("complete");
                ajaxCalls.slice(ajaxCalls.indexOf(ajaxCall));
            });
        ajaxCalls.push(ajaxCall);

        displayResult();


    }else {
        $("#row_result").html('');
        $("#row_result").removeClass('loading');
    }
}


function displayResult() {
    if (!resultDisplayed)
    {
        $('#search').removeClass("vertical-center");
        $('#search').addClass("top-search");
        $('#column_logo').removeClass("small-12");
        $('#column_logo').addClass("small-5");
        $('#column_logo').addClass("medium-3");
        $('#column_logo').addClass("large-2");
        $('#column_search').removeClass("small-12");
        $('#column_search').addClass("small-7");
        $('#column_search').addClass("medium-9");
        $('#column_search').addClass("large-10");
        $('#column_logo').html('<a href="<?= SITE_URL ?>">' + $('#column_logo').html() + '</a>');
        resultDisplayed = true;
    }
}

function cancelAjaxCalls() {
    debug("Cancelling all ajax calls...");
    debug(ajaxCalls);
    ajaxCalls.forEach(function (a) {
        a.abort();
        ajaxCalls.slice(ajaxCalls.indexOf(a),1);
    });

}

function debug(msg) {
    if (_debug) {
        console.log(msg);
    }
}