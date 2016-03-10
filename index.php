<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LE trombi</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/typeahead.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <style>
        /*.vertical-center {*/
            /*min-height: 100%;  !* Fallback for browsers do NOT support vh unit *!*/
            /*min-height: 100vh; !* These two lines are counted as one :-)       *!*/

            /*display: flex;*/
            /*align-items: center;*/
        /*}*/

        .vertical-center {
            vertical-align:middle;
        }
    </style>
</head>
<body>

<div class="container vertical-center">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <form action="search.php">
                <div class="form-group" id="searchbar">
                    <input class="typeahead form-control" type="text">
                </div>
                <button type="submit" class="btn btn-default">Va chercher!</button>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/typeahead.bundle.min.js"></script>
</body>

<script>
    var results = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: 'search.php?name=%QUERY',
            wildcard: '%QUERY'
        }
    });

    $('#searchbar .typeahead').typeahead(null, {
        name: 'results',
        display: 'nom',
        source: results
    });

</script>
</html>