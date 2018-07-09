<?php
class QuestionnaireController{
    public static $step;
    public static $perseverance_key;
    public static $neatness_key;
    public static $self_learning_key;
    public static $industry_key;

    public function actionStart(){
        static::$step = 1;
        if(isset($_GET['step']))
            static::$step = $_GET['step'];

        if (isset($_POST['submit-1'])) {
            $_SESSION['data']['sex'] = trim(strip_tags( $_POST['sex'] ));
            $_SESSION['data']['name'] = trim(strip_tags( $_POST['name'] ));
            $_SESSION['data']['lastname'] = trim(strip_tags( $_POST['lastname'] ));
            $_SESSION['data']['patronymic'] = trim(strip_tags( $_POST['patronymic'] ));
            $_SESSION['data']['bday'] = trim(strip_tags( $_POST['bday'] ));
            header('Location: ?step=2');
        }
        if (isset($_POST['submit-2'])) {
            $EditingImage = new EditingImage();
            $EditingImage->editAvatar();
        }
        if (isset($_POST['submit-2'])  && isset($_GET['fail'])) {
            $_SESSION['data']['color'] = trim(strip_tags( $_POST['color'] ));
        }elseif(isset($_POST['submit-2']) && !isset($_GET['fail'])){
            $_SESSION['data']['color'] = trim(strip_tags( $_POST['color'] ));
            header('Location: ?step=3');
        }
        if(isset($_SESSION['data']['skills'])){
            static::$perseverance_key = array_search('усидчивость', $_SESSION['data']['skills']);
            static::$neatness_key = array_search('опрятность', $_SESSION['data']['skills']);
            static::$self_learning_key = array_search('самообучаемость', $_SESSION['data']['skills']);
            static::$industry_key = array_search('трудолюбие', $_SESSION['data']['skills']);
        }
        if (!empty($_POST['skills']) && isset($_POST['submit-chek'])) {
            $_SESSION['data']['qualities'] =  trim(strip_tags( $_POST['qualities'] ));
            $_SESSION['data']['skills'] =   $_POST['skills'] ;
            header('Location: ?step=4');
        }
        if (isset($_POST['submit-4'])) {
            $EditingImage = new EditingImage();
            $EditingImage->editPhoto();
        }
        if (isset($_POST['submit-4']) && !isset($_GET['fail'])) {
            header('Location: ?step=5');
        }
        if (static::$step == 5) {
            static::insertProfile();
        }
        $view = new View();
        $view->display("start.php");
    }

    public static function insertProfile(){
        $ins = array();
        $data = array();
        foreach ($_SESSION['data'] as $key => $val){
            $$key = $_SESSION['data'][$key];
        }
        $cols = array_keys($_SESSION['data']);
        foreach($cols as $col){
            $ins[] = ":".$col;
            $data[':'.$col] = $_SESSION['data'][$col];
        }
        $cols = implode(', ', $cols);
        $ins = implode(', ', $ins);

        if (isset($_SESSION['data']['skills'])){
            $skills = implode ('|', $_SESSION['data']['skills']);
        }else{
            $skills = false;
        }
        if (isset($_SESSION['data']['photo'])){
            $photos = implode ('|', $_SESSION['data']['photo']);
        }else{
            $photos = false;
        }
        $data[':skills'] = $skills;
        $data[':photo'] = $photos;

        $profile = new ProfileModel();
        $profile->insert($cols, $ins, $data);
    }

    public function actionAdmin(){
        $profiles = ProfileModel::getAll();

        $view = new View();
        $view->profiles = $profiles;
        $view->display("admin-panel.php");
    }

    public function actionOne(){
        $id = $_GET['id'];
        $profile = ProfileModel::getOne($id);

        $view = new View();
        $view->profile = $profile[0];
        $view->profile->skills = str_replace('|', ', ',$view->profile->skills);
        $view->profile->photo = explode('|', $view->profile->photo);
        $view->display("one.php");
    }

    public function actionFilterLastname(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['lastname'])){
            $post = trim(strip_tags($_POST['lastname']));
            $filerProfiles = ProfileModel::search( $post,'lastname');
            
            $view = new View();
            $view->filerProfiles = $filerProfiles;
            $view->title = "<h2>по фамилии</h2>";
            $view->display("filter.php");
        }
    }

    public function actionFilterSkills(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['skills'])){
            $post = $_POST['skills'];
            list($val_1, $val_2, $val_3, $val_4) = $post;
            if (isset($val_1))
                $val_1 = '%'.$val_1.'%';
            if(isset($val_2))
                $val_2 = '%'.$val_2.'%';
            if(isset($val_3))
                $val_3 = '%'.$val_3.'%';
            if(isset($val_4))
                $val_4 = '%'.$val_4.'%';
            $val = $val_1.$val_2.$val_3.$val_4;
            $filerProfiles = ProfileModel::search($val, 'skills');

            $view = new View();
            $view->filerProfiles = $filerProfiles;
            $view->title = "<h2>по навыкам</h2>";
            $view->display("filter.php");
        }
    }

    public function actionFilterDate(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['bday'])){
            $post = $_POST['bday'];
            $post = explode('-',$post);
            list($year, $month, $day) = $post;
            $val = $year.'-'.$month.'-'.$day;
            $filerProfiles = ProfileModel::search($val,  'bday');

            $view = new View();
            $view->filerProfiles = $filerProfiles;
            $view->title = "<h2>по дате рождения</h2>";
            $view->display("filter.php");
        }
    }


}