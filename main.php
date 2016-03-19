<?php
$structures = json_decode(file_get_contents(STRUCTURE_API_URL));
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LE Trombi</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="foundation-icons/foundation-icons.css">
    <link rel="icon"
          type="image/png"
          href="favicon.ico">
    <script src="js/jquery-2.2.1.min.js"></script>
</head>
<body>
<div class="vertical-center" id="search">
    <div class="row" id="row_search">
        <div class="small-12 column" id="column_logo">
            <img src="images/TrombiUTC.png">
        </div>
        <div class="small-12 column" id="column_search">
            <input id="searchField" type="text" placeholder="Search someone"/>
        </div>
    </div>
    <div class="row column" id="row_advanced_link">
        <div class="column small-centered advanced_search_text">
            <a id="advanced_link">Advanced search</a>
        </div>
    </div>
    <div class="row hide" id="row_advanced_search">
        <form>
            <div class="small-12 medium-6 column">
                <select id="combo_structure">
                    <option value="">Structure</option>
                    <?php
                    foreach ($structures as $struct) {
                        echo '<option value="' . $struct->structNomId .'">' . $struct->structureLibelle . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="small-12 medium-6 column">
                <select id="combo_sous_structure">
                    <option value="">Sous-Structure</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="row" id="row_result">
    <div class="small-12">
    </div>
</div>

<script type="text/javascript">
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
                   html += '<option value="'+ elt.structNomId +'">'+ elt.structureLibelle +'</option>';
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
</script>
</body>
</html>
