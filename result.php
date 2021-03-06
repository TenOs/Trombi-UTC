<?php

require_once 'config.php';

$name = (!empty($_GET['name']) ? str_replace(" ", "+", $_GET['name']) : '');
$url = SEARCH_URL. $name;
$url .= (!empty($_GET['struct']) ? '&struct=' . $_GET['struct'] : '');
$url .= (!empty($_GET['sstruct']) ? '&sstruct=' . $_GET['sstruct'] : '');

$results = json_decode(file_get_contents($url));


if (empty($results)) { ?>
    <div class="row column callout alert">
        <h3><i class="fi-alert"/> Aucun résultat</h3>
    </div>
<?php }

foreach ($results as $item) { ?>

    <div class="row">
        <div class="small-12 column">
            <div class="callout">
                <div class="media-object">
                    <div class="media-object-section">
                        <div class="thumbnail">
                            <img src= "<?=$item->photo?>" style="max-height: 150px;max-width: 120px;">
                        </div>
                    </div>
                    <div class="media-object-section">
                        <h4><?=$item->nom.' ('.$item->login.')'?></h4>
                        <?= (!empty($item->poste)?"<h6>$item->poste</h6>":'') ?>
                        <p>
                            <?php if (!empty($item->structure)) { ?>
                                <i class="fi-info"/> <?=$item->structure . (!empty($item->sousStructure)?' - '.$item->sousStructure:'')?><br/>
                            <?php } ?>
                            <?= (!empty($item->bureau)?" <i class=\"fi-map\"/> $item->bureau<br/>":'') ?>
                            <?= (!empty($item->tel)?" <i class=\"fi-telephone\"/> $item->tel<br/>":'') ?>
                            <?= (!empty($item->tel2)?" <i class=\"fi-telephone\"/> $item->tel2<br/>":'') ?>
                            <a href="mailto:<?=$item->mail?>"><i class="fi-mail"/> <?=$item->mail?></a>
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php } ?>

