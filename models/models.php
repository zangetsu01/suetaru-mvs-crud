<?php

function connectDB()  
{
    return new PDO('mysql:host=localhost;dbname=suetabdnew', 'root', '');
}

function selectAllAds($pdo, $get) 
{
    $sql = "SELECT ca.id, ca.name as add_name, ca.price, ca.description, ca.photo_path,
            b.name as brand_name, m.name as model_name,
            s.years, s.mileage, s.engine_volume, s.power_hp, s.color
            FROM car_ads ca
            JOIN brands b ON ca.brand_id = b.id
            JOIN models m ON ca.model_id = m.id
            JOIN specifications s ON ca.id = s.car_id
            WHERE 1=1";
    
    $params = [];
    
    if (!empty($get['brand_id'])) {
        $sql .= " AND ca.brand_id = :brand_id";
        $params[':brand_id'] = $get['brand_id'];
    }
    
    if (!empty($get['model_id'])) {
        $sql .= " AND ca.model_id = :model_id";
        $params[':model_id'] = $get['model_id'];
    }
    
    $sql .= " ORDER BY ca.id DESC";
    
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function selectAdById($pdo, $get) 
{
    $sql = "SELECT ca.*, ca.photo_path,  
            b.name as brand_name, m.name as model_name,
            s.years, s.mileage, s.engine_volume, s.power_hp, s.color,
            u.email as user_email, u.role as user_role
            FROM car_ads ca
            JOIN brands b ON ca.brand_id = b.id
            JOIN models m ON ca.model_id = m.id
            JOIN specifications s ON ca.id = s.car_id
            LEFT JOIN users u ON ca.user_id = u.id
            WHERE ca.id = :id";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $get['id']]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function selectAdForEdit($pdo, $get) 
{
    $sql = "SELECT ca.id, ca.name as add_name, ca.price, ca.description, ca.photo_path, ca.user_id,
            b.id as brand_id, b.name as brand_name, 
            m.id as model_id, m.name as model_name,
            s.years, s.mileage, s.engine_volume, s.power_hp, s.color, s.id as spec_id
            FROM car_ads ca
            JOIN brands b ON ca.brand_id = b.id
            JOIN models m ON ca.model_id = m.id
            JOIN specifications s ON ca.id = s.car_id
            WHERE ca.id = :id";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $get['id']]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function selectAllBrands($pdo) 
{
    $statement = $pdo->prepare("SELECT id, name FROM brands ORDER BY name");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function selectAllModels($pdo) 
{
    $statement = $pdo->prepare("SELECT id, name, brand_id FROM models ORDER BY name");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function insertCarAd($pdo, $post, $files) 
{
    $photo_path = null;
    if (isset($files['photo']) && $files['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_path = saveUploadedFile($files['photo'], 'car_ads');
    }
    
    $sql = "INSERT INTO car_ads (name, price, brand_id, model_id, description, photo_path, user_id) 
            VALUES (:name, :price, :brand_id, :model_id, :description, :photo_path, :user_id)";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':name' => $post['name'],
        ':price' => $post['price'],
        ':brand_id' => $post['brand_id'],
        ':model_id' => $post['model_id'],
        ':description' => $post['description'],
        ':photo_path' => $photo_path,
        ':user_id' => $_SESSION['user_id']
    ]);
    
    $car_id = $pdo->lastInsertId();
    
    $sql = "INSERT INTO specifications (years, mileage, power_hp, engine_volume, color, car_id) 
            VALUES (:years, :mileage, :power_hp, :engine_volume, :color, :car_id)";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':years' => $post['year'],
        ':mileage' => $post['mileage'],
        ':power_hp' => $post['power_hp'],
        ':engine_volume' => $post['engine_volume'],
        ':color' => $post['color'],
        ':car_id' => $car_id
    ]);
}

function updateCarAd($pdo, $post, $files) 
{
    $stmt = $pdo->prepare("SELECT photo_path FROM car_ads WHERE id = :id");
    $stmt->execute([':id' => $post['id']]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
    $photo_path = $current['photo_path'];
    
    if (isset($files['photo']) && $files['photo']['error'] === UPLOAD_ERR_OK) {
        if ($photo_path && file_exists($photo_path)) {
        unlink($photo_path);
        }
        // Сохраняем новое
        $photo_path = saveUploadedFile($files['photo'], 'car_ads');
    }
    
    $sql = "UPDATE car_ads SET 
            name = :name, 
            price = :price, 
            description = :description, 
            photo_path = :photo_path, 
            brand_id = :brand_id, 
            model_id = :model_id
            WHERE id = :id";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':id' => $post['id'],
        ':name' => $post['name'],
        ':price' => $post['price'],
        ':description' => $post['description'],
        ':photo_path' => $photo_path,
        ':brand_id' => $post['brand_id'],
        ':model_id' => $post['model_id']
    ]);
    
    $sql = "UPDATE specifications SET 
            years = :years, 
            mileage = :mileage, 
            power_hp = :power_hp, 
            engine_volume = :engine_volume, 
            color = :color 
            WHERE car_id = :car_id";
    
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':car_id' => $post['id'],
        ':years' => $post['year'],
        ':mileage' => $post['mileage'],
        ':power_hp' => $post['power_hp'],
        ':engine_volume' => $post['engine_volume'],
        ':color' => $post['color']
    ]);
}


function deleteCarAd($pdo, $get) 
{
    // Сначала получаем путь к фото и удаляем файл
    $stmt = $pdo->prepare("SELECT photo_path FROM car_ads WHERE id = :id");
    $stmt->execute([':id' => $get['id']]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($ad && $ad['photo_path'] && file_exists($ad['photo_path'])) {
        unlink($ad['photo_path']);
    }
    
    $sql = "DELETE FROM specifications WHERE car_id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $get['id']]);
    
    $sql = "DELETE FROM car_ads WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $get['id']]);
}

function tryLogin($pdo, $post) 
{
    if (empty($post['email']) || empty($post['password'])) {
        return false;
    }
    
    $sql = "SELECT id, email, password, role FROM users WHERE email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute([':email' => $post['email']]);
    $user = $statement->fetch();
    
    if ($user && password_verify($post['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        return true;
    }
    
    return false;
}

function createUser($pdo, $post) 
{
    if (empty($post['email']) || empty($post['password'])) {
        return 'Заполните все поля';
    }
    
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        return 'Введите корректный email';
    }
    
    if (strlen($post['password']) < 4) {
        return 'Пароль должен быть не менее 4 символов';
    }
    
    if ($post['password'] !== $post['confirm_password']) {
        return 'Пароли не совпадают';
    }
    
    $sql = "SELECT id FROM users WHERE email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute([':email' => $post['email']]);
    
    if ($statement->fetch()) {
        return 'Пользователь с таким email уже существует';
    }
    
    $hashed_password = password_hash($post['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'user')";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':email' => $post['email'],
        ':password' => $hashed_password
    ]);
    
    return true;  // Успех!
}

function isAdmin($pdo) 
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    $sql = "SELECT role FROM users WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $_SESSION['user_id']]);
    $user = $statement->fetch();
    
    return $user && $user['role'] === 'admin';
}

function isLogged() 
{
    return isset($_SESSION['user_id']);
}

function getCurrentUser($pdo) 
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    $sql = "SELECT id, email, role FROM users WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $_SESSION['user_id']]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function logout() 
{
    session_destroy();
}

function getPhotoData($photo_blob) 
{
    if ($photo_blob) {
        return 'data:image/jpeg;base64,' . base64_encode($photo_blob);
    }
    return null;
}

function saveUploadedFile($file, $subdir = '') 
{
    $upload_dir = __DIR__ . '/../uploads/';
    if ($subdir) {
        $upload_dir .= $subdir . '/';
    }
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
    return 'uploads/' . ($subdir ? $subdir . '/' : '') . $filename;
    }
    return null;
}

function getPhotoUrl($photo_path) 
{
    if (empty($photo_path)) {
        return null;
    }
    
    // Проверяем существование файла относительно корня сайта
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $photo_path;
    
    if (file_exists($fullPath)) {
        return '/' . $photo_path;
    }
    
    return null;
}

function validateBrandModel($pdo, $brand_id, $model_id) 
{
    $stmt = $pdo->prepare("SELECT id FROM models WHERE id = :model_id AND brand_id = :brand_id");
    $stmt->execute([':model_id' => $model_id, ':brand_id' => $brand_id]);
    return $stmt->fetch() !== false;
}

?>