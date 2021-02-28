<?php

    $dir = './assets/files/';
    if (isset($_GET['route'])) {
        $dir = $dir . $_GET['route'];
    }
    
    $files = scandir($dir, SCANDIR_SORT_ASCENDING);
    foreach($files as $key => $file) {
        if($file == '.' || $file == '..' || $file == '.DS_Store'){
            unset($files[$key]);
        }
    }
    //var_dump($files);

    function routeShow($dir, $file) {
        if(filetype($dir . $file) == 'dir'){
            if (isset($_GET['route'])) {
                return 'index.php?route='. $_GET['route'] . $file . '/' ;
            }
            return 'index.php?route=' . $file . '/';
        }
        else{
            return $dir . $file;
        }
    }


    function routeAdd() {
        if (isset($_GET['route'])) {
            return 'assets/fileupload.php?route='. $_GET['route'];
        }
        else{
            return 'assets/fileupload.php';
        }
    }

    function routeDel($file) {
        if (isset($_GET['route'])) {
            return 'assets/filedelete.php?file='. $_GET['route'] . $file;
        }
        return 'assets/filedelete.php?file=' . $file ;
    }

    function dirShow() {
        if (isset($_GET['route'])) {
            return 'files/'. $_GET['route'];
        }
        else{
            return 'files/';
        }
    }

    function dirReturn() {
        if (isset($_GET['route'])) {
            $routes = explode('/', $_GET['route']);
            if(count($routes) <= 2){
                return '<a class="btn btn-primary btn-sm" href="index.php" >Späť</a>';  
            }
            else {
                $route = '';
                for($i = 0; $i < count($routes)-2; ++$i) {
                    $route = $route . $routes[$i] . '/';
                }
                return '<a class="btn btn-primary btn-sm" href="index.php?route=' . $route . '" >Späť</a>';
            }
            
        }
        else{
            return '';
        }
    }

    function routeAddDir() {
        if (isset($_GET['route'])) {
            return 'assets/adddir.php?route='. $_GET['route'];
        }
        else{
            return 'assets/adddir.php';
        }
    }
?>

<!DOCTYPE HTML>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Tomas Drus">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <!--<link rel="stylesheet" href="assets/css/reset.css">-->
    <link rel="stylesheet" href="assets/css/main.css">

    <title>Súborový systém</title>
</head>

<body>

<div class="container">
    <h2 class="text-center py-5">Súborový systém</h2>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="<?= routeAdd() ?>" method="post" enctype="multipart/form-data">
                <div class="col-12" style="margin-bottom: 20px">
                    <h4 class="text-center mb-4">Pridať súbor</h4>
                    <label for="fileToUpload" class="form-label">Vyberte súbor na vloženie</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                </div>
                <div class="col-12" style="margin-bottom: 20px">
                    <label for="fileName" class="form-label">Nový názov súboru (voliteľné)</label>
                    <input type="text" name="fileName" id="fileName" class="form-control" placeholder="my-new-file-name">
                </div>
                <div class="col-12" style="margin-bottom: 20px">
                    <button class="btn btn-primary w-100" type="submit">Pridať súbor</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form action="<?= routeAddDir() ?>" method="post" enctype="multipart/form-data">
                <div class="col-12" style="margin-bottom: 20px">
                    <h4 class="text-center mb-4">Pridať priečinok</h4>
                    <label for="dirName" class="form-label">Názov priečinku</label>
                    <input type="text" name="dirName" id="dirName" class="form-control" placeholder="my-new-dir-name">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Pridať Priečinok</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container" style="margin-top: 30px">
    
    <h5 class="d-inline" style="margin-right: 20px">Adresár: <?= dirShow() ?></h5>
    <?= dirReturn() ?>

    <table class="table table-striped table-hover display" id="table">
        
        <thead>
            <tr>
                <th>Názov</th>
                <th>Druh</th>
                <th>Veľkosť</th>
                <th>Dátum</th>
                <th>Del</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($files as $file): ?>
                <tr>
                    <td><a href="<?= routeShow($dir, $file) ?>"><?= $file ?></a></td>
                    <td><?= filetype($dir . $file) ?></td>
                    <td><?= is_dir($dir . $file) ? '' : filesize($dir . $file) ?></td>
                    <td><?= is_dir($dir . $file) ? '' : date('j.n.Y G:i', filemtime($dir . $file)) ?></td>
                    <td><a href="<?= routeDel($file) ?>">&#x2718;</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>

</html>