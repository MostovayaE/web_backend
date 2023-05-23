<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
include('megamodule.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
 
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors=err_declare();

  $messages = msg_declare($messages, $errors);

  // Складываем предыдущие значения полей в массив, если есть.
  // При этом санитизуем все данные для безопасного отображения в браузере.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['fio_value']));
  $values['email'] = empty($_COOKIE['email_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['email_value']));
  $values['date_of_birth'] = empty($_COOKIE['date_of_birth_value']) ? '' :htmlspecialchars(strip_tags($_COOKIE['date_of_birth_value']));
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['gender_value']));
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['limbs_value']));

  if(!empty($_COOKIE['abilities_value'])){
  foreach (unserialize($_COOKIE['abilities_value']) as $res) {
    $values['abilities'][$res-1] = empty($res) ? '' : htmlspecialchars(strip_tags($res));
}
}
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['bio_value']));
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : htmlspecialchars(strip_tags($_COOKIE['checkbox_value']));

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  //todo fix_errors
  if (count(array_filter($errors)) === 0 && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {


        $stmt = $db->prepare("SELECT * FROM application2 where user_id=?");
        $stmt -> execute([$_SESSION['uid']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $values['fio'] = empty($result[0]['name']) ? '' : htmlspecialchars(strip_tags($result[0]['name']));
        $values['email'] = empty($result[0]['email']) ? '' : htmlspecialchars(strip_tags($result[0]['email']));
  $values['date_of_birth'] = empty($result[0]['date_of_birth']) ? '' :htmlspecialchars(strip_tags($result[0]['date_of_birth']));
  $values['gender'] = empty($result[0]['gender']) ? '' : htmlspecialchars(strip_tags($result[0]['gender']));
  $values['limbs'] = empty($result[0]['limbs']) ? '' : htmlspecialchars(strip_tags($result[0]['limbs']));
 
  $values['bio'] = empty($result[0]['bio']) ? '' : htmlspecialchars(strip_tags($result[0]['bio']));
  $values['checkbox'] = empty($result[0]['checkbox']) ? '' : htmlspecialchars(strip_tags($result[0]['checkbox']));
  $values['limbs'] = empty($result[0]['limbs']) ? '' : htmlspecialchars(strip_tags($result[0]['limbs']));

  $stmt = $db->prepare("SELECT * FROM app_ability2 where id_app=(SELECT id FROM application2 where user_id=?) ");
 

  $stmt -> execute([$_SESSION['uid']]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($result as $res) {
    $values['abilities'][$res["id_ab"]-1] = empty($res) ? '' : htmlspecialchars(strip_tags($res["id_ab"]));
}
  



    // TODO: загрузить данные пользователя из БД
    // и заполнить переменную $values,
    // предварительно санитизовав.
  printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
 
    if (isset($_POST['logout']) && $_POST['logout'] == 'true') {
        session_destroy();
        setcookie(session_name(), '', time() - 3600);
        setcookie('PHPSESSID', '', time() - 3600, '/');
       
        header('Location: ./');
        exit();
    }
    
  // Проверяем ошибки.
    $data = [
        'name' => $_POST['fio'],
        'email' => $_POST['email'],
        'date_of_birth' => $_POST['date_of_birth'],
        'gender' => $_POST['gender'],
        'limbs' => $_POST['limbs'],
        'bio' => $_POST['bio'],
        'checkbox' => $_POST['checkbox']
    ];
    $abilities = $_POST['abilities'];
    $errors=validateFormData($data, $abilities);
  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_of_birth_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('abilities_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('checkbox_error', '', 100000);
  }

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
         
          if (!empty($_POST['token'])) {
              if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                  header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                  exit;
              }
          }
          else {
              header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
              exit;
          }
          $stmt = $db->prepare("SELECT id FROM application2 WHERE user_id = ?");
          $stmt -> execute([$_SESSION['uid']]);
          $result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $id_of_app = $result3[0]["id"];
          
          $data = [
              'name' => $_POST['fio'],
              'email' => $_POST['email'],
              'date_of_birth' => $_POST['date_of_birth'],
              'gender' => $_POST['gender'],
              'limbs' => $_POST['limbs'],
              'bio' => $_POST['bio'],
              'checkbox' => $_POST['checkbox']
          ];
          
          $abilities = $_POST['abilities'];
          
          update_application($db, $id_of_app, $data, $abilities);
  }
  else {
    // Генерируем уникальный логин и пароль.
    // TODO: сделать механизм генерации, например функциями rand(), uniqid(), md5(), substr().
    $login = substr(uniqid('', true), -8, 8);
    $pass = uniqid();
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $pass);

    // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
    // ...


        
        // Подготовленный запрос. Не именованные метки.
        try {
          $stmt = $db->prepare("INSERT INTO user (user, pass) VALUES (?,?)");
          $stmt -> execute([$login, password_hash($pass, PASSWORD_DEFAULT)]);
          $id = $db->lastInsertId();
            $stmt = $db->prepare("INSERT INTO application2 (name,email,date_of_birth,gender,limbs,bio,checkbox, user_id) VALUES
    (?,?,?,?,?,?,?,?)");
            $stmt -> execute([$_POST['fio'], $_POST['email'], $_POST['date_of_birth'], $_POST['gender'], $_POST['limbs'], $_POST['bio'], $_POST['checkbox'], $id]);
            $id = $db->lastInsertId();
            $stmt = $db->prepare("INSERT INTO app_ability2 (id_app, id_ab) VALUES (?,?)");
            foreach ($_POST['abilities'] as $ability) {
                $stmt->execute([$id, $ability]);
            }
            
            
            
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }

  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: ./');
}
