<?php 

$curl = curl_init();

$url = "https://gitlab.com/api/v4/projects/37998250/issues";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl); 
// echo $result;
$listBoards = json_decode($result, true);

// var_dump($listBoards);
// yg mau diambil = title, assignee


curl_close($curl);


$no = 0;
$listBoard = [];
foreach ($listBoards as $data) {
    $listBoard[$no++] = $data['assignee']['name'];
}

?>

<!-- <pre>
</pre> -->

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List Isuues | Fadhlanarrizal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1 class="title">List Issues</h1>
        <?php 
            $tasks = array_count_values($listBoard);
            foreach ($tasks as $assignee => $task) : ?>

        <div class="card text-bg-light my-4" style="max-width: 23rem;">
            <div class="card-header"><?= $assignee; ?></div>
            <div class="card-body">
                <!-- <h5 class="card-title">List Tasks :</h5> -->
                <li class="list-group-item">
                        <?php foreach ($listBoards as $listBoard) : ?>
                        <?php if ($listBoard['assignee']['name'] == $assignee) : 
                            $created_at = $listBoard['updated_at']; 
                            $dateCreated = date("d", strtotime($created_at));
                            $now = date('d');
                            $intervalDay = intval($now) - intval($dateCreated); 
                            ?>
                        <li class="list-group-item">
                            <?php if($listBoard['labels'][0] == "Doing") : ?>
                                [<?=$intervalDay?>]
                                <a target="_blank" href="<?= $listBoard['web_url']; ?>"><?= $listBoard['title']; ?> </a>
                            </li>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endforeach ?>
                </li>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</body>

</html>