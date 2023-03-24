<html lang="ru">

<head>
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Задание 3</title>
    <link rel="stylesheet" href="style3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js" defer></script>
    <script src="main3.js" defer></script>
</head>

<body>
    <div class="col col-10 col-md-6" id="forma">
        <div id="button">
            <button type="button" id="closebutton">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="form1" action="" method="POST">
            <div class="form-group">
                <label for="name">Иvsмя:</label>
                <input name="fio" id="name" class="form-control" placeholder="Введите ваше имя">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>

                <input name="email" type="email" class="form-control" id="email" placeholder="Введите вашу почту">

            </div>
            <div class="form-group">

                Дата рождения:
                <input name="date_of_birth" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />

            </div>
            <div class="form-group">
                Пол:
                <label for="g1"><input type="radio" class="form-check-input" name="gender" id="g1" value="m">
                    Мужской</label>
                <label for="g2"><input type="radio" class="form-check-input" name="gender" id="g2" value="w">
                    Женский</label>
            </div>
            <div class="form-group">
                Количество конечностей:
                <label for="l1"><input type="radio" class="form-check-input" name="limbs" id="l1" value="2">
                    2</label>
                <label for="l2"><input type="radio" class="form-check-input" name="limbs" id="l2" value="4">
                    4</label>

            </div>
            <div class="form-group">
                <label for="mltplslct">Сверх способности:</label>
                <select class="form-control" name="abilities[]" id="mltplslct" multiple="multiple">
                    <option value="1">бессмертие</option>
                    <option value="2">прохождение сквозь стены</option>
                    <option value="3">левитация</option>
                </select>
            </div>


            <div class="form-group">
                <label for="bio">Биография:</label>
                <textarea name="bio" id="bio" rows="3" class="form-control"></textarea>
            </div>
            <label><input type="checkbox" class="form-check-input" id="checkbox" value="1" name="checkbox">
                с контрактом ознакомлен (а) </label><br>
            <input type="submit" id="btnend" class="btn btn-primary" value="Отправить">
        </form>
    </div>
</body>