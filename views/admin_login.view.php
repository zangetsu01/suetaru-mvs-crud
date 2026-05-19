<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход для администратора</title>
    <link rel="stylesheet" href="../models/main.css">
</head>
<body>
    <div class="container">
        <div class="form-box" style="max-width: 400px;">
            <h2>🔐 Вход для администратора</h2>
            <?php if ($error): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email администратора" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
            <a href="/index.php" style="display: block; text-align: center; margin-top: 15px;">← На главную</a>
        </div>
    </div>
</body>
</html>