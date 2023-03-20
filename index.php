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
} elseif (isset($_POST["clear"])) {
    array_splice($rss, 0);
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

<body class="text-muted">
    <p class="float-right p-2">
        <a class="btn btn-warning" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
            Help
        </a>
    </p>
    <div class="row p-2">
        <div class="col">
            <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="card card-body text-warning">
                    Examples of sites RSS Feed:
                    <ul class="list-group text-muted">
                        <li class="list-group-item">http://rss.cnn.com/rss/cnn_topstories.rss</li>
                        <li class="list-group-item">https://justinpot.com/feed/</li>
                        <li class="list-group-item">https://rss.art19.com/apology-line</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container pt-5">
            <div class="row pt-5">
                <div class="col-6 mx-auto pt-5">
                    <h4 class="text-center text-dark pb-2">RSS Feed Reader 📥</h4>
                    <form method="post">
                        <label class="badge " for="urls">Enter your URLs:</label>
                        <textarea class="form-control" id="urls" name="urls"></textarea>
                        <input class="btn btn-light mt-2" type="submit" name="submit" value="Submit">
                        <input class="btn btn-light mt-2" type="submit" name="clear" value="Clear">
                    </form>
                </div>
            </div>



            <?php if (in_array(false, $rss, true) && (count($rss) > 0)) : ?>
                <p><?php echo "rss not available" ?></p>
            <?php elseif (!in_array(false, $rss, true)) : ?>

                <div class="row mt-5 mb-5">
                    <?php foreach ($rss as $item) : ?>
                        <h4 class="col-9 mb-5 pt-4"><?= $item->channel->title ?></h4>

                        <?php foreach ($item->channel->item as $date) : ?>
                            <div class="card col-sm-4" style="width: 18rem;">
                                <img class="card-img-top" src="<?= $date->image->url ?>" alt="Photo for post">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $date->title ?></h5>
                                    <p class="card-text"><?= substr($date->description, 0, 150) . "..." ?></p>
                                    <a href="<?= $date->link ?>" class="btn btn-primary">Go to post</a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>