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
                        echo '<option value="' . $struct->structure->structId .'">' . $struct->structureLibelle . '</option>';
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

<script>
    var SITE_URL = "<?= SITE_URL ?>";
</script>
<script src="js/main.js"></script>
</body>
</html>
