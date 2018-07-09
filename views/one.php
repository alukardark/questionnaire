<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Заголовок</title>
    <meta name="author" content="web-studio">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">

</head>
<body>
<h1>Админ-панель</h1>
<h2>Профиль</h2>

<div class="form-group">
    Пол: <?php echo $profile->sex ?>
</div>
<hr>
<div class="form-group">
    Имя: <?php echo $profile->name ?>
</div>
<hr>
<div class="form-group">
    Фамилия: <?php echo $profile->lastname ?>
</div>
<hr>
<div class="form-group">
    Отчество: <?php echo $profile->patronymic ?>
</div>
<hr>
<div class="form-group">
    Дата рождения: <?php echo $profile->bday ?>
</div>
<hr>
<div class="form-group">
    Аватар: <?php echo $profile->avatar ?>
    <?php
    if (!empty($profile->avatar)):
    ?>
        <img src="../upload/<?php echo $profile->avatar ?>" alt="avatar">
    <?php
    endif;
    ?>
</div>
<hr>
<div class="form-group">
    Любимый цвет: <div class="color" style="background: <?php echo $profile->color ?>;"></div>
    <span ><?php echo $profile->color ?></span>
</div>
<hr>
<div class="form-group">
    Качества: <?php echo $profile->qualities ?>
</div>
<hr>
<div class="form-group">
    Навики: <?php echo $profile->skills ?>
</div>
<hr>
<div class="form-group">
    <?php
    if (!empty($profile->photo[0])){
        ?>
        <img src="../upload/<?php echo $profile->photo[0]?>" alt="">
        <?php
    }
    if (!empty($profile->photo[1])){
        ?>
        <img src="../upload/<?php echo $profile->photo[1]?>" alt="">
        <?php
    }
    if (!empty($profile->photo[2])){
        ?>
        <img src="../upload/<?php echo $profile->photo[2]?>" alt="">
        <?php
    }
    if (!empty($profile->photo[3])){
        ?>
        <img src="../upload/<?php echo $profile->photo[3]?>" alt="">
        <?php
    }
    if (!empty($profile->photo[4])){
        ?>
        <img src="../upload/<?php echo $profile->photo[4]?>" alt="">
        <?php
    }
    if (!empty($profile->photo[5])){
        ?>
        <img src="../upload/<?php echo $profile->photo[5]?>" alt="">
        <?php
    }
    ?>
</div>


</body>
</html>