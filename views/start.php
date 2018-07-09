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
<h1>Анкетирование</h1>

<?php
if ( QuestionnaireController::$step == 1) {
    ?>
    <h2>Шаг 1</h2>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" >

        <label>Укажите ваш пол: <span class="star-red">*</span></label>

        <div class="form-group">
            <label><span>Mужской</span><input type="radio" name="sex" value="мужской"
                    <?php if($_SESSION['data']['sex']=="мужской") echo " checked "?> required></label>
            <br>
            <label><span>Женский</span><input type="radio" name="sex" value="женский"
                    <?php if($_SESSION['data']['sex']=="женский") echo " checked "?> required></label>
        </div>

        <div class="form-group">
            <label>Ваше имя: </label>
            <input type="text" name="name" class="form-control" value="<?php if(isset($_SESSION['data']['name'])) echo $_SESSION['data']['name']?>">
        </div>
        <div class="form-group">
            <label>Ваша фамилия: <span class="star-red">*</span></label>
            <input type="text" name="lastname" class="form-control" value="<?php if(isset($_SESSION['data']['lastname'])) echo $_SESSION['data']['lastname']?>" required>
        </div>
        <div class="form-group">
            <label>Ваше отчество: </label>
            <input type="text" name="patronymic" class="form-control"value="<?php if(isset($_SESSION['data']['patronymic'])) echo $_SESSION['data']['patronymic']?>" >
        </div>
        <div class="form-group">
            <label>Ваша дата рождения(гггг-мм-дд): <span class="star-red">*</span></label>
            <input type="date" name="bday" class="form-control" value="<?php if(isset($_SESSION['data']['bday'])) echo $_SESSION['data']['bday']?>" required>
        </div>

        <input type="submit" name="submit-1">
    </form>
    <p>Поля, отмеченные звездочкой (<span class="star-red">*</span>), обязательны для заполнения.</p>
    <?php
}elseif (QuestionnaireController::$step == 2) {
    ?>
    <h2>Шаг 2</h2>

    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Загрузка аватарки: </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            <input type="file" name="file">
        </div>
        <div class="form-group">
            <label>Укажите любимый цвет: </label>
            <input type="color" name="color" value="<?php if(isset($_SESSION['data']['color'])) echo $_SESSION['data']['color']?>">
        </div>
        <input type="submit" name="submit-2">
    </form>

    <p>Аватарка не должна весить более 100Кб, и допускаются только форматы: *.png, *.jpg/jpeg, .*gif </p>

    <a class="back" href="?step=1">Назад</a>

    <?php
}elseif (QuestionnaireController::$step == 3) {
    ?>
    <h2>Шаг 3</h2>

    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Ваши личные качества: </label>
            <textarea name="qualities" class="form-control"><?php if(isset($_SESSION['data']['qualities'])) echo $_SESSION['data']['qualities']?></textarea>
        </div>

        <label>Укажите ваши навыки: <span class="star-red">*</span></label>

        <div class="form-group">
            <label><span>Усидчивость</span><input type="checkbox" name="skills[]"value="усидчивость" <?php if($_SESSION['data']['skills'][QuestionnaireController::$perseverance_key]=="усидчивость") echo " checked "?>></label>
            <br>
            <label><span>Опрятность</span><input type="checkbox" name="skills[]" value="опрятность" <?php if($_SESSION['data']['skills'][QuestionnaireController::$neatness_key]=="опрятность") echo " checked "?>></label>
            <br>
            <label><span>Самообучаемость</span><input type="checkbox" name="skills[]" value="самообучаемость" <?php if($_SESSION['data']['skills'][QuestionnaireController::$self_learning_key]=="самообучаемость") echo " checked "?>></label>
            <br>
            <label><span>Трудолюбие</span><input type="checkbox" name="skills[]" value="трудолюбие" <?php if($_SESSION['data']['skills'][QuestionnaireController::$industry_key]=="трудолюбие") echo " checked "?>></label>
        </div>

        <input type="submit" name="submit-chek">
    </form>
    <?
    if( empty($_POST['skills']) && isset($_POST['submit-chek']) ){
        echo "<p>Пожалуйста, выберите навыки из списка</p>";
    }
    ?>
    <a class="back" href="?step=2">Назад</a>
    <?php
}elseif (QuestionnaireController::$step == 4) {
    ?>
    <h2>Шаг 4</h2>

    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <label>Загрузка фотографии: </label>
        <div class="form-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
            <input type="file" name="file[1]">
            <input type="file" name="file[2]">
            <input type="file" name="file[3]">
            <input type="file" name="file[4]">
            <input type="file" name="file[5]">
        </div>
        <input type="submit" name="submit-4">
    </form>
    <p>Каждая фотография не должна весить более 1М, и допускаются только форматы: *.png, *.jpg/jpeg, .*gif </p>
    <a class="back" href="?step=3">Назад</a>
    <?php
}elseif (QuestionnaireController::$step == 5) {
    echo "<p>Анкетирование прошло успешно</p>";
    echo "<a class='admin-button' href='/Questionnaire/Admin'>Админ-панель</a>";
}

?>








</body>
</html>