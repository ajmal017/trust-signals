<?php
class Includes extends Core {
  public function getTitle() {}
  public function getContent() {
    $this->changeLauncher("clean");
    $adds = new Additions();
    $action = '';
    if(isset($_POST['action'])) {
        $action = $_POST['action'];
    }
    global $mysqli;
    $date = date("Y-m-d");
    $user = $adds->getUserData();
    if($adds->isAuth() && $user['group'] == 'admin') {
      if($action == 'save' && isset($_POST['include']) && isset($_POST['id'])) {
        $id = $adds->toInteger($_POST['id']);
        $includes = json_encode($_POST['include']);
        $mysqli->query("UPDATE `packages` SET `includes` = '{$includes}' WHERE `id` = '{$id}'");
        exit("success");
      }
    }
    else {
      echo "<p>Проблема аутентификации</p>";
    }
  }
}
?>
