
<?php

session_start();

include "includes/db.php";

header('Content-Type: application/json');

header('Content-Type: application/json');
if(!isset($_SESSION['user_id']))
{
    echo json_encode([
        "error"=>"Please login first."
    ]);
    exit();
}


$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$weight  = isset($_POST['weight']) ? (float) $_POST['weight'] : 0;   // kilograms
$heightCm = isset($_POST['height']) ? (float) $_POST['height'] : 0;  // centimeters
$age     = isset($_POST['age']) ? (int) $_POST['age'] : 0;
$gender  = isset($_POST['gender']) ? strtolower(preg_replace('/[^a-zA-Z]/', '', $_POST['gender'])) : 'other';

$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
if ($name === '') { $name = 'there'; }

if ($weight <= 0 || $heightCm <= 0 || $weight > 500 || $heightCm > 300 || $age <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Please enter valid name, age, height and weight values.']);
    exit;
}

$height = $heightCm / 100; // meters
$user_id = $_SESSION['user_id'];


$bmi = round($weight / ($height * $height), 1);

function classify(float $bmi): array {
    if ($bmi < 18.5) {
        return ['label' => 'Underweight', 'key' => 'under', 'color' => '#4FA6D9', 'risk' => 'Moderate'];
    } elseif ($bmi < 25) {
        return ['label' => 'Normal Weight', 'key' => 'normal', 'color' => '#0E7C66', 'risk' => 'Low'];
    } elseif ($bmi < 30) {
        return ['label' => 'Overweight', 'key' => 'over', 'color' => '#E8A33D', 'risk' => 'Moderate'];
    } else {
        return ['label' => 'Obese', 'key' => 'obese', 'color' => '#FF6B5B', 'risk' => 'High'];
    }
}

$category = classify($bmi);


$minHealthy = round(18.5 * $height * $height, 1);
$maxHealthy = round(24.9 * $height * $height, 1);


$waterIntake = round(($weight * 0.035), 1);


if ($gender === 'male') {
    $calories = (10 * $weight) + (6.25 * $heightCm) - (5 * $age) + 5;
} elseif ($gender === 'female') {
    $calories = (10 * $weight) + (6.25 * $heightCm) - (5 * $age) - 161;
} else {
    $calories = (10 * $weight) + (6.25 * $heightCm) - (5 * $age) - 78; // neutral average
}
$calories = (int) round($calories);

function dietFor(string $key): array {
    switch ($key) {
        case 'under':
            return [
                ['icon' => '🥜', 'label' => 'Nuts & Seeds'],
                ['icon' => '🥛', 'label' => 'Dairy'],
                ['icon' => '🍗', 'label' => 'Protein-Rich Foods'],
                ['icon' => '🥑', 'label' => 'Healthy Fats'],
            ];
        case 'normal':
            return [
                ['icon' => '🥗', 'label' => 'Balanced Diet'],
                ['icon' => '🍎', 'label' => 'Fruits'],
                ['icon' => '🥦', 'label' => 'Vegetables'],
                ['icon' => '🌾', 'label' => 'Whole Grains'],
            ];
        default: 
            return [
                ['icon' => '🥗', 'label' => 'Salad'],
                ['icon' => '🥬', 'label' => 'Vegetables'],
                ['icon' => '🍎', 'label' => 'Fruits'],
                ['icon' => '🥣', 'label' => 'Oats'],
            ];
    }
}

function exerciseFor(string $key): array {
    switch ($key) {
        case 'under':
            return [
                ['icon' => '🏋️', 'label' => 'Strength Training'],
                ['icon' => '🚶', 'label' => 'Light Cardio'],
                ['icon' => '🧘', 'label' => 'Yoga'],
                ['icon' => '😴', 'label' => 'Rest Well'],
            ];
        case 'normal':
            return [
                ['icon' => '🚶', 'label' => 'Walking'],
                ['icon' => '🧘', 'label' => 'Yoga'],
                ['icon' => '🏊', 'label' => 'Swimming'],
                ['icon' => '🤸', 'label' => 'Stretching'],
            ];
        default: 
            return [
                ['icon' => '🚶', 'label' => 'Brisk Walking'],
                ['icon' => '🏃', 'label' => 'Jogging'],
                ['icon' => '🚴', 'label' => 'Cycling'],
                ['icon' => '🏊', 'label' => 'Swimming'],
            ];
    }
}

function tipsFor(string $key): array {
    switch ($key) {
        case 'under':
            return [
                ['icon' => '🍽️', 'label' => 'Eat Frequent Meals'],
                ['icon' => '🍗', 'label' => 'Add Protein'],
                ['icon' => '📈', 'label' => 'Track Progress'],
                ['icon' => '🩺', 'label' => 'Consult a Doctor'],
            ];
        case 'normal':
            return [
                ['icon' => '🍽️', 'label' => 'Maintain Balance'],
                ['icon' => '😴', 'label' => 'Sleep Well'],
                ['icon' => '💧', 'label' => 'Stay Hydrated'],
                ['icon' => '🩺', 'label' => 'Regular Checkups'],
            ];
        default: 
            return [
                ['icon' => '🍔', 'label' => 'Avoid Junk Food'],
                ['icon' => '🥤', 'label' => 'Reduce Sugar'],
                ['icon' => '💧', 'label' => 'Drink More Water'],
                ['icon' => '🏃', 'label' => 'Exercise 45 Minutes'],
            ];
    }
}
$stmt = $conn->prepare("
INSERT INTO bmi_reports
(
user_id,
age,
gender,
height,
weight,
bmi,
category,
water,
calories
)

VALUES(?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
"iisddddsi",

$user_id,

$age,

$gender,

$heightCm,

$weight,

$bmi,

$category['label'],

$waterIntake,

$calories

);

$stmt->execute();

echo json_encode([
    'name'           => $name,
    'bmi'            => $bmi,
    'category'       => $category['label'],
    'categoryKey'    => $category['key'],
    'color'          => $category['color'],
    'healthRisk'     => $category['risk'],
    'minHealthy'     => $minHealthy,
    'maxHealthy'     => $maxHealthy,
    'waterIntake'    => $waterIntake,
    'calories'       => $calories,
    'diet'           => dietFor($category['key']),
    'exercise'       => exerciseFor($category['key']),
    'tips'           => tipsFor($category['key']),
]);