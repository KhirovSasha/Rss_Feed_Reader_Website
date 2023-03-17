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
</head>

<body>
    <h4>URL</h4>
    <form method="post">
        <label for="urls">Введите URL-адреса через запятую:</label>
        <textarea id="urls" name="urls" rows="5" cols="50"></textarea>
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
</body>

</html>