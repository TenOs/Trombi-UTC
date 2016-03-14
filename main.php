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
<div class="row vertical-center" id="row_search">
    <div class="small-12 column" id="column_logo">
        <img src="images/TrombiUTC.png">
    </div>
    <div class="small-12 column" id="column_search">
        <input id="searchField" type="text" placeholder="Search someone"/>
    </div>
</div>
<div class="row" id="row_result">
    <div class="small-12">
    </div>
</div>

<script type="text/javascript">
    var _debug = true;
    var ajaxCalls = new Array();

    $( document ).ready(function() {
        $("#searchField").first().focus();
    });

    $('#searchField').on('input', function (e) {
        cancelAjaxCalls();
        var text = $('#searchField').val();
        if (text.length > 2) {
            $("#row_result").html('');
            $("#row_result").addClass("loading");
            var ajaxCall = $.ajax({
                    url: 'result.php',
                    data: {name: text}
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

            $('#row_search').removeClass("vertical-center");
            $('#row_search').addClass("top-search");
            $('#column_logo').removeClass("small-12");
            $('#column_logo').addClass("small-5");
            $('#column_logo').addClass("medium-3");
            $('#column_logo').addClass("large-2");
            $('#column_search').removeClass("small-12");
            $('#column_search').addClass("small-7");
            $('#column_search').addClass("medium-9");
            $('#column_search').addClass("large-10");
        }else {
            $("#row_result").html('');
            $("#row_result").removeClass('loading');
        }
    });


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
