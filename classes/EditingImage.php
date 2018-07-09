<?php

class EditingImage{

    public function imageCorrect($image, $background = false, $width, $height, $token="xxx", $type=".")
    {
        global $i;

        if (!$background) {
            $background = imagecolorallocate($image, 255, 255, 255);
        }
        $img_h = imagesy($image);
        $img_w = imagesx($image);

        // создание нового ихображение(холста)
        $img = imagecreatetruecolor($width, $height);

        // заполнение фона
        imagefill($img, 0, 0, $background);

        // смещение в центр
        $xoffset = ($width - $img_w) / 2;
        $yoffset = ($height - $img_h) / 2;

        imagecopymerge($img, $image, $xoffset, $yoffset, 0, 0, $img_w, $img_h, 100);

        if (isset($i)) {
            imagejpeg($img, __DIR__ . '/../upload/' . $token.".".$type, 100);
        }else{
            imagejpeg($img, __DIR__ . '/../upload/' . $token.".".$type, 100);
        }

        imagedestroy($img);

    }

    public function editAvatar($width=60, $height=60){

        $file = $_FILES['file']['name'];
        $token = md5(uniqid(true));

        if($_FILES['file']['error'] == 1 || $_FILES['file']['error'] == 2){
            echo "Размер принятого файла превысил максимально допустимый размер <br>";
            $_GET['fail'] = true;

        }elseif($_FILES['file']['error'] == 0){

            $type = strtolower(substr(strrchr($file,"."),1));

            if ($type !== 'jpg' && $type !== 'jpeg' && $type !== 'gif' && $type !== 'png'){
                echo "Неверный формат загружаемого файла <br>";
                $_GET['fail'] = true;
            }else{
                move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__."/../upload/" . $token.".".$type);
                
                // обращаемся к переменной $file, как к уже существующему файлу на диске
                $file = __DIR__.'/../upload/'. $token.".".$type;
                echo $file;
                // Изменяем размер холста
                switch ($type){
                    case 'jpg':
                        $img = imageCreateFromjpeg($file);
                        break;
                    case 'jpeg':
                        $img = imageCreateFromjpeg($file);
                        break;
                    case 'png':
                        $img = imageCreateFrompng($file);
                        break;
                    case 'gif':
                        $img = imagecreatefromgif($file);
                        break;
                }

                $this->imageCorrect($img, false, $width, $height, $token, $type);

                $_SESSION['data']['avatar'] = $token.".".$type ;

            }
        }
        elseif(($_FILES['file']['error'] == 4)) {
            $_SESSION['data']['avatar'] = false ;
        }
        else{
            echo "При загрузке файла произошла ошибка <br>";
            $_GET['fail'] = true;
        }

    }

    public function editPhoto(){

        global  $i;
        $file = $_FILES['file']['name'];
        $i=0;
        foreach ($file as $one_file) {

            $token = md5(uniqid(true));
            $i++;
            $width=600;
            $height=700;

            if ($_FILES['file']['error'][$i] == 4) {
                $_SESSION['data']['photo'][$i] = false ;
                continue;
            }elseif($_FILES['file']['error'][$i] == 1 || $_FILES['file']['error'][$i] == 2){
                echo "Размер принятого файла в поле №$i превысил максимально допустимый размер <br>";
                $_GET['fail'] = true;
                continue;

            }elseif($_FILES['file']['error'][$i] == 0){
                $type = strtolower(substr(strrchr($one_file,"."),1));
                if ($type !== 'jpg' && $type !== 'jpeg' && $type !== 'gif' && $type !== 'png'){
                    echo "<p>.$type - В поле №$i неверный формат загружаемого файла: ".$_FILES['file']['name'][$i]."</p>";
                    $_GET['fail'] = true;
                    continue;
                }else{
                    move_uploaded_file($_FILES["file"]["tmp_name"][$i], __DIR__."/../upload/" . $token.".".$type);

                    // обращаемся к переменной $one_file, как к уже существующему файлу на диске
                    $one_file = __DIR__.'/../upload/'.$token.".".$type;

                    // Изменяем размер холста
                    switch ($type){
                        case 'jpg':
                            $img = imageCreateFromjpeg($one_file);
                            break;
                        case 'jpeg':
                            $img = imageCreateFromjpeg($one_file);
                            break;
                        case 'png':
                            $img = imageCreateFrompng($one_file);
                            break;
                        case 'gif':
                            $img = imagecreatefromgif($one_file);
                            break;
                    }
                    list($width_orig, $height_orig) = getimagesize($one_file);

                    $ratio_orig = $width_orig/$height_orig;

                    if ($width/$height > $ratio_orig) {
                        $width = $height*$ratio_orig;
                    } else {
                        $height = $width/$ratio_orig;
                    }
                    $this->imageCorrect($img, false, $width, $height, $token, $type);


                        $_SESSION['data']['photo'][$i] = $token.".".$type ;



                    echo "<p> Изображение в поле №$i загружено удачно: ".$_FILES['file']['name'][$i]."</p>";
                }
            }
            else{
                echo "<p> При загрузке файла в поле №$i произошла ошибка</p> <br>";
                $_GET['fail'] = true;
                continue;
            }

        }
    }




}
