<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать - <?= htmlspecialchars($ad['add_name']) ?></title>
    <link rel="stylesheet" href="../models/main.css">
    <script>
        const allModels = <?php echo json_encode($allModels); ?>;
        const currentBrandId = <?= $ad['brand_id'] ?>;
        const currentModelId = <?= $ad['model_id'] ?>;
        
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
        
        document.addEventListener('DOMContentLoaded', function() {
            updateModels();
            const modelSelect = document.getElementById('model_id');
            for(let i = 0; i < modelSelect.options.length; i++) {
                if(modelSelect.options[i].value == currentModelId) {
                    modelSelect.options[i].selected = true;
                    break;
                }
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🚗 Sueta.ru</div>
            <a href="/index.php" class="btn-add">← Назад</a>
        </div>
        <div class="form-box">
            <h2>✏️ Редактирование объявления</h2>
            <form method="POST" enctype="multipart/form-data" action="update.php">
                <input type="hidden" name="id" value="<?= $ad['id'] ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($ad['add_name']) ?>" required>
                <input type="file" name="photo" accept="image/*">
                <input type="number" name="price" value="<?= $ad['price'] ?>" required>
                <select name="brand_id" id="brand_id" onchange="updateModels()" required>
                    <option value="">Выберите марку</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>" <?= ($brand['id'] == $ad['brand_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brand['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="model_id" id="model_id" required>
                    <option value="">Выберите модель</option>
                </select>
                <input type="number" name="year" value="<?= $ad['years'] ?>" required>
                <input type="number" name="mileage" value="<?= $ad['mileage'] ?>" required>
                <input type="text" name="engine_volume" value="<?= htmlspecialchars($ad['engine_volume']) ?>" required>
                <input type="number" name="power_hp" value="<?= $ad['power_hp'] ?>" required>
                <input type="text" name="color" value="<?= htmlspecialchars($ad['color']) ?>" required>
                <textarea name="description" rows="3" required><?= htmlspecialchars($ad['description']) ?></textarea>
                <button type="submit">Сохранить изменения</button>
            </form>
        </div>
    </div>
</body>
</html>