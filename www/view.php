<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все записи на экскурсии</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 50px auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .empty { text-align: center; color: #666; padding: 20px; }
        a { color: #007cba; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>📋 Все записи на экскурсии</h1>
    
    <?php if (file_exists('data.txt')): ?>
        <?php
        $lines = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!empty($lines)): 
        ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Дата экскурсии</th>
                        <th>Маршрут</th>
                        <th>Аудиогид</th>
                        <th>Язык</th>
                        <th>Время записи</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lines as $index => $line): ?>
                        <?php
                        $data = explode(';', $line);
                        if (count($data) >= 7):
                        ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($data[0]) ?></td>
                                <td><?= htmlspecialchars($data[1]) ?></td>
                                <td><?= htmlspecialchars($data[2]) ?></td>
                                <td><?= htmlspecialchars($data[3]) ?></td>
                                <td><?= htmlspecialchars($data[4]) ?></td>
                                <td><?= htmlspecialchars($data[5]) ?></td>
                                <td><?= htmlspecialchars($data[6]) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <p><strong>Всего записей:</strong> <?= count($lines) ?></p>
        <?php else: ?>
            <div class="empty">
                <p>📭 Записей пока нет</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty">
            <p>📭 Файл с данными не найден</p>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 30px;">
        <a href="index.php">← На главную</a> | 
        <a href="form.html">📝 Создать новую запись</a>
    </div>
</body>
</html> 
