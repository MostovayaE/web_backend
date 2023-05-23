<html>
<head>
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Задание 6</title>
    <link rel="stylesheet" href="style5.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js" defer></script>
</head>

  <body>



<body>
    <div class="col col-10 col-md-11" id="forma">
    <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }


  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>    

<?php
if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])){
    echo '
        <div class = "login">
        <form action="" method="POST" >
            <input type="hidden" name="logout" value="true">
            <button type="submit">Выйти</button>
        </form>
        </div>
    ';
}
else 
    echo'
    <div class = "login">
    <form action="login.php" target="_blank">
    <button>Войти</button>
    </form>
    </div>
';
?>
        <form id="form1" action="" method="POST">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input name="fio" id="name" class="form-control <?php if ($errors['fio']) {print 'is-invalid';} ?>" placeholder="Введите ваше имя"  value="<?php print $values['fio']; ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>

                <input name="email" type="email" class="form-control <?php if ($errors['email']) {print 'is-invalid';} ?>" id="email" placeholder="Введите вашу почту" value="<?php print $values['email']; ?>">

            </div>
            <div class="form-group">

                Дата рождения:
                <input name="date_of_birth" type="date" class="form-control <?php if ($errors['date_of_birth']) {print 'is-invalid';} ?>" value="<?php print $values['date_of_birth']; ?>" />

            </div>
            <div class="form-group">
                Пол:
                <label for="g1"><input type="radio" class="form-check-input <?php if ($errors['gender']) {print 'is-invalid';} ?>" name="gender" id="g1" value="m" <?php if ($values['gender']=='m') {print 'checked';} ?>>
                    Мужской</label>
                <label for="g2"><input type="radio" class="form-check-input <?php if ($errors['gender']) {print 'is-invalid';} ?>" name="gender" id="g2" value="w" <?php if ($values['gender']=='w') {print 'checked';} ?>>
                    Женский</label>
            </div>
            <div class="form-group">
                Количество конечностей:
                <label for="l1"><input type="radio" class="form-check-input <?php if ($errors['limbs']) {print 'is-invalid';} ?>" name="limbs" id="l1" value="2" <?php if ($values['limbs']=='2') {print 'checked';} ?>>
                    2</label>
                <label for="l2"><input type="radio" class="form-check-input <?php if ($errors['limbs']) {print 'is-invalid';} ?>" name="limbs" id="l2" value="4" <?php if ($values['limbs']=='4') {print 'checked';} ?>>
                    4</label>

            </div>
            <div class="form-group">
                <label for="mltplslct">Сверх способности:</label>
                <select class="form-control <?php if ($errors['abilities']) {print 'is-invalid';} ?>" name="abilities[]" id="mltplslct" multiple="multiple">
                    <option value="1" <?php if(!empty($values['abilities'][0])) {if ($values['abilities'][0]=='1') {print 'selected';}} ?>>бессмертие</option>
                    <option value="2" <?php if(!empty($values['abilities'][1])) {if ($values['abilities'][1]=='2') {print 'selected';}} ?>>прохождение сквозь стены</option>
                    <option value="3" <?php if(!empty($values['abilities'][2])) {if ($values['abilities'][2]=='3') {print 'selected';}} ?>>левитация</option>
                </select>
            </div>


            <div class="form-group">
                <label for="bio">Биография:</label>
                <textarea name="bio" id="bio" rows="3" class="form-control <?php if ($errors['bio']) {print 'is-invalid';} ?>" ><?php print $values['bio']; ?></textarea>
            </div>
            <label><input type="checkbox" class="form-check-input <?php if ($errors['checkbox']) {print 'is-invalid';} ?>" id="checkbox" value="1" name="checkbox" <?php if ($values['checkbox']=='1') {print 'checked';} ?>>
                с контрактом ознакомлен (а) </label><br>
            <input type="submit" id="btnend" class="btn btn-primary" value="Отправить">
        </form>
    </div>

</body>


</html>
