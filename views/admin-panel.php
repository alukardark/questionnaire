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

<form action="" method="POST">
    <p style="font-weight:bold; font-size: 20px">Фильтр:</p>
    <p>Дата рождения(гггг-мм-дд) :</p>
    <input type="date" name="bday" class="form-control">

    <p>Фамилия:</p>
    <input type="text" name="lastname" class="form-control">

    <p>Навыки:</p>
    <label>
        <span>Усидчивость</span><input type="checkbox" name="skills[]" value="усидчивость">
    </label><br>
    <label>
        <span>Опрятность</span><input type="checkbox" name="skills[]" value="Опрятность">
    </label><br>
    <label>
        <span>Самообучаемость</span><input type="checkbox" name="skills[]" value="Самообучаемость">
    </label><br>
    <label>
        <span>Трудолюбие</span><input type="checkbox" name="skills[]" value="Трудолюбие">
    </label><br>

    <input type="submit" name="submit" value="Старт">
</form>
<?
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $actionFilter = new QuestionnaireController();
    $actionFilter->actionFilterLastname();
    $actionFilter->actionFilterSkills();
    $actionFilter->actionFilterDate();
}else{
    ?>
    <h2>Список профилей:</h2>
    <?php
    $i = 1;
    foreach ($profiles as $profile):
        echo "Профиль №".$i;
        ?>
        <p>
            <?php echo $profile->name ?>
            <?php echo $profile->lastname ?>
            <?php echo $profile->patronymic ?>
        </p>
        <a href="One/?id=<?php echo $profile->id ?>">Просмотреть профиль полностью</a>
        <hr>
        <?php
        $i++;
    endforeach;
}
?>
</body>
</html>