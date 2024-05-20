<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div style="display: grid;">
        <?php
        foreach (scandir('small') as $key => $src) {
            if ($key < 2) continue;
            echo '<a href="big/' . $src . '"><img src="small/' . $src . '"></a>';
        }
        ?>
    </div>

</body>

</html>