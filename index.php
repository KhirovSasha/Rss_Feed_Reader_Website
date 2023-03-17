<?php
libxml_use_internal_errors(TRUE);

$rss = [];
$err = "";
$urlArray = [];

if (isset($_POST["submit"])) {

    $urls = $_POST['urls'];

    $delimiter = '/[\n\s]+/';

    $urlArray = preg_split($delimiter, $urls);
    $urlArray = array_map('trim', $urlArray);
    $urlArray = array_filter($urlArray);

    foreach ($urlArray as $url) {
        $xml = simplexml_load_file($url);
        array_push($rss, $xml);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rss Feed Reader</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h4>URL</h4>
    <form method="post">
        <label for="urls">Введите URL-адреса через запятую:</label>
        <textarea id="urls" name="urls"></textarea>
        <input type="submit" name="submit" value="Отправить">
    </form>

    <?php if (in_array(false, $rss, true) && (count($rss) > 0)) : ?>
        <p><?php echo "rss not available" ?></p>
    <?php elseif (!in_array(false, $rss, true)) : ?>

        <div class="">
            <?php foreach ($rss as $item) : ?>
                <h4><?= $item->channel->title ?></h4>
                <?php foreach ($item->channel->item as $date) : ?>
                    <div>
                        <p><a href="<?= $date->link ?>"><?= $date->title ?></a></p>
                        <p><?= substr($date->description, 0, 150) . "..." ?></p>
                        <img src="<?= $date->image->url ?>" alt="<?= $date->image->title ?>">
                    </div>
                <?php endforeach ?>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>