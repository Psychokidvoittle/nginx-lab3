<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница - Запись на экскурсию</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 4px; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 4px; }
        .cookie-info { background: #fff3cd; padding: 10px; border-radius: 4px; margin: 10px 0; }
        a { color: #007cba; text-decoration: none; margin: 0 10px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>🚀 Лабораторная работа №3</h1>
    <h2>Система записи на экскурсии</h2>
    
    <!-- Вывод ошибок -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="error">
            <h3>❌ Ошибки при заполнении формы:</h3>
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Вывод успешного сообщения -->
    <?php if (isset($_SESSION['form_data'])): ?>
        <div class="success">
            <h3>✅ Данные успешно сохранены!</h3>
            <p><strong>Имя:</strong> <?= $_SESSION['form_data']['name'] ?></p>
            <p><strong>Email:</strong> <?= $_SESSION['form_data']['email'] ?></p>
            <p><strong>Дата:</strong> <?= $_SESSION['form_data']['date'] ?></p>
            <p><strong>Маршрут:</strong> <?= $_SESSION['form_data']['route'] ?></p>
            <p><strong>Аудиогид:</strong> <?= $_SESSION['form_data']['audioguide'] ?></p>
            <p><strong>Язык:</strong> <?= $_SESSION['form_data']['language'] ?></p>
            <p><strong>Время записи:</strong> <?= $_SESSION['form_data']['timestamp'] ?></p>
        </div>
        <?php unset($_SESSION['form_data']); ?>
    <?php endif; ?>

    <!-- Информация из куки (штрафное задание) -->
    <?php if (isset($_COOKIE['last_user_name'])): ?>
        <div class="cookie-info">
            <h3>🍪 Информация из cookies:</h3>
            <p>Последний пользователь: <strong><?= $_COOKIE['last_user_name'] ?></strong></p>
            <p>Email: <strong><?= $_COOKIE['last_user_email'] ?></strong></p>
            <p><em>Эта информация хранится в cookies вашего браузера</em></p>
        </div>
    <?php endif; ?>

    <div class="container">
        <h3>📊 Статистика записей:</h3>
        <?php
        if (file_exists('data.txt')) {
            $lines = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $totalRecords = count($lines);
            echo "<p>Всего записей: <strong>$totalRecords</strong></p>";
            
            // Подсчет по маршрутам
            $routes = [];
            foreach ($lines as $line) {
                $data = explode(';', $line);
                if (count($data) >= 4) {
                    $route = $data[3];
                    $routes[$route] = ($routes[$route] ?? 0) + 1;
                }
            }
            
            if (!empty($routes)) {
                echo "<p>Распределение по маршрутам:</p>";
                echo "<ul>";
                foreach ($routes as $route => $count) {
                    echo "<li>$route: $count записей</li>";
                }
                echo "</ul>";
            }
        } else {
            echo "<p>Записей пока нет</p>";
        }
        ?>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="form.html">📝 Заполнить форму записи</a>
        <a href="view.php">👀 Посмотреть все записи</a>
    </div>

    <div style="margin-top: 20px; font-size: 14px; color: #666;">
        <p><strong>Технологии:</strong> PHP, Сессии, Cookies, Файловое хранилище</p>
    </div>
</body>
</html> 
