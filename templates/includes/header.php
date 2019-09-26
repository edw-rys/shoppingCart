<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo isset($obj->tittle)?$obj->tittle:'Home';?></title>
    <link rel="stylesheet" href="<?php echo CSS.'/base.css';?> ">
    <link rel="stylesheet" href="<?php echo CSS.'/style.css';?> ">
    <link rel="stylesheet" href="<?php echo CSS.'/iconistic.min.css';?> ">
    <link rel="icon" type="image/png" href ="<?php echo IMAGES?>logo.png">
    <script type="application/javascript">
        ()=>{}
        const URL_APP='<?php echo URL?>';
    </script>
</head>
<body>
    <?php require_once CART;?>
