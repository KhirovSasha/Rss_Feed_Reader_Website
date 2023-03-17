<?php
libxml_use_internal_errors(TRUE);

$rss = [];
$err = "";

if (isset($_POST["submit"])) {
    $xml = simplexml_load_file($_POST['rssWeb']);

    if ($xml === FALSE) {
        $err = "rss not available";
    } else {
        $rss = $xml;
    }
}

function addPosts($array){
    echo "<h2>".$array->channel->title."</h2>";
    foreach($array->channel->item as $item){
        echo "<div><p><a href='".$item->link."'>".$item->title."</a></p>";
        echo "<p>".$item->description."</p>";
        echo "<img src='".$item->image->url."' alt='".$item->image->title."'></div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rss Reader</title>
</head>

<body>
    <h4>URL</h4>
    <form method="post">
        <input type="url" name="rssWeb">
        <input type="submit" name="submit" value="Add">
    </form>

    <?php
        if(strlen($err) != 0) {
            echo '<h2>'. $err . '</h2>';	
        }
        elseif (count($rss)!=0){
            addPosts($rss);
        }
    ?>
</body>

</html>