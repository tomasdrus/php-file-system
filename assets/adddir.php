<?php
    
    $route = "files/";
    
    if (isset($_GET['route'])) {
        $route = "files/" . $_GET['route'];
    }
    if($_POST['dirName'] == ''){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    mkdir($route . $_POST['dirName'], 0777, true);
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;