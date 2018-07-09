<?php
echo "<h2>Список отфильтрованных профилей $title</h2>";

$i = 1;
foreach ($filerProfiles as $filerProfile):
    echo "Найденный профиль №".$i;
    ?>
    <p>
        <?php echo $filerProfile->name ?>
        <?php echo $filerProfile->lastname ?>
        <?php echo $filerProfile->patronymic ?>
    </p>
    <a href="One/?id=<?php echo $filerProfile->id ?>">Просмотреть профиль полностью</a>
    <hr>
    <?php
    $i++;
endforeach;
?>
