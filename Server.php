<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['name']) || !isset($data['price'])) {
    echo json_encode(["success" => false, "error" => "Niepoprawne dane"]);
    exit;
}

$product = $data['name'];
$price = $data['price'];
$username = "gracz123";  // Tutaj pobierasz nick gracza (można dodać formularz)

require 'vendor/autoload.php';  // Załaduj Stripe (lub API Przelewy24)

\Stripe\Stripe::setApiKey('TWÓJ_STRIPE_SECRET_KEY');

$paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => $price * 100,
    'currency' => 'pln',
    'payment_method_types' => ['card'],
]);

// Po zatwierdzeniu płatności dodaj rangę przez RCON
if ($paymentIntent) {
    $rcon = fsockopen("127.0.0.1", 25575);
    if ($rcon) {
        fwrite($rcon, "login rconpassword\n");
        fwrite($rcon, "lp user $username parent add $product\n");
        fclose($rcon);
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>
