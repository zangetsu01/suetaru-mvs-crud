<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - Sueta.ru</title>
    <link rel="stylesheet" href="../models/main.css">
    
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>🔐 Вход</h2>
            
            <?php if ($error): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
            
            <p style="text-align: center; margin-top: 15px;">
                Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
            </p>
            
            <a href="/index.php" style="display: block; text-align: center; margin-top: 10px;">← На главную</a>
        </div>
    </div>
</body>
</html>