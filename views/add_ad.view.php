<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить авто</title>
    <link rel="stylesheet" href="../models/main.css">
    <script>
        const allModels = <?php echo json_encode($allModels); ?>;
        
        function updateModels() {
            const brandId = document.getElementById('brand_id').value;
            const modelSelect = document.getElementById('model_id');
            modelSelect.innerHTML = '<option value="">Выберите модель</option>';
            if (!brandId) return;
            const filteredModels = allModels.filter(model => model.brand_id == brandId);
            filteredModels.forEach(model => {
                const option = document.createElement('option');
                option.value = model.id;
                option.textContent = model.name;
                modelSelect.appendChild(option);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🚗 Sueta.ru</div>
            <div style="display: flex; gap: 10px;">
                <?php if ($isAdmin): ?>
                    <span style="background: #ff6b00; color: white; padding: 8px 16px; border-radius: 30px;">👑 Админ</span>
                <?php else: ?>
                    <span style="background: #28a745; color: white; padding: 8px 16px; border-radius: 30px;">👤 <?= htmlspecialchars($currentUser['email']) ?></span>
                <?php endif; ?>
                <a href="/index.php" class="btn-add" style="background: #6c757d;">← Назад</a>
            </div>
        </div>
        <div class="form-box">
            <h2>📝 Новое объявление</h2>
            <form method="POST" enctype="multipart/form-data" action="add_ad.php">
                <input type="text" name="name" placeholder="Название объявления" required>
                <input type="file" name="photo" accept="image/*">
                <input type="number" name="price" placeholder="Цена ₽" required>
                
                <select name="brand_id" id="brand_id" onchange="updateModels()" required>
                    <option value="">Выберите марку</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                
                <select name="model_id" id="model_id" required>
                    <option value="">Сначала выберите марку</option>
                </select>
                
                <input type="number" name="year" placeholder="Год выпуска" required>
                <input type="number" name="mileage" placeholder="Пробег (км)" required>
                <input type="text" name="engine_volume" placeholder="Объём двигателя (л)" required>
                <input type="number" name="power_hp" placeholder="Мощность (л.с.)" required>
                <input type="text" name="color" placeholder="Цвет" required>
                <textarea name="description" placeholder="Описание" rows="3"></textarea>
                <button type="submit">✅ Опубликовать</button>
            </form>
        </div>
    </div>
</body>
</html>