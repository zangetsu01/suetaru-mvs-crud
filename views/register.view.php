<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../models/main.css">
</head>
<body>
    <div class="container">
        <div class="form-box" style="max-width: 400px;">
            <h2>📝 Регистрация</h2>
            
            <?php if ($error): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <p style="color: green; text-align: center;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль (мин. 4 символа)" required>
                <input type="password" name="confirm_password" placeholder="Повторите пароль" required>
                <button type="submit">Зарегистрироваться</button>
            </form>
            
            <p style="text-align: center; margin-top: 15px;">
                <a href="login.php">Войти</a> | <a href="/index.php">На главную</a>
            </p>
        </div>
    </div>
</body>
</html>