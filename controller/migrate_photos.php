
<?php
require_once 'models/models.php';

$pdo = connectDB();
$ads = $pdo->query("SELECT id, photo FROM car_ads WHERE photo IS NOT NULL")->fetchAll();

foreach ($ads as $ad) {
    if ($ad['photo']) {
        if (!file_exists('uploads/car_ads')) {
            mkdir('uploads/car_ads', 0777, true);
        }
        $filename = 'car_ad_' . $ad['id'] . '_' . time() . '.jpg';
        file_put_contents('uploads/car_ads/' . $filename, $ad['photo']);
        $stmt = $pdo->prepare("UPDATE car_ads SET photo_path = :path WHERE id = :id");
        $stmt->execute([
            ':path' => 'uploads/car_ads/' . $filename,
            ':id' => $ad['id']
        ]);
        echo "Migrated ad ID: {$ad['id']}\n";
    }
}

echo "Done!\n";
?>