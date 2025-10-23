<?php
session_start();

// Получаем данные из формы
$name = htmlspecialchars($_POST['name'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$date = htmlspecialchars($_POST['date'] ?? '');
$route = htmlspecialchars($_POST['route'] ?? '');
$audioguide = isset($_POST['audioguide']) ? 'Да' : 'Нет';
$language = htmlspecialchars($_POST['language'] ?? '');

// Валидация данных
$errors = [];

if (empty($name)) {
    $errors[] = "Имя не может быть пустым";
}

if (empty($email)) {
    $errors[] = "Email не может быть пустым";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Некорректный формат email";
}

if (empty($date)) {
    $errors[] = "Дата не может быть пустой";
}

if (empty($route)) {
    $errors[] = "Маршрут не может быть пустым";
}

// Если есть ошибки - сохраняем в сессию и возвращаем
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Сохраняем данные в сессию
$_SESSION['form_data'] = [
    'name' => $name,
    'email' => $email,
    'date' => $date,
    'route' => $route,
    'audioguide' => $audioguide,
    'language' => $language,
    'timestamp' => date('Y-m-d H:i:s')
];

// Сохраняем в куки (штрафное задание)
setcookie('last_user_name', $name, time() + 86400 * 30, '/'); // 30 дней
setcookie('last_user_email', $email, time() + 86400 * 30, '/');

// Сохраняем в файл
$dataLine = implode(';', [
    $name,
    $email,
    $date,
    $route,
    $audioguide,
    $language,
    date('Y-m-d H:i:s')
]) . "\n";

file_put_contents('data.txt', $dataLine, FILE_APPEND);

// Перенаправляем на главную страницу
header("Location: index.php");
exit();
?> 
