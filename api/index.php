<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$host = "localhost";
$dbname = "school";
$username = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo json_encode(["error"=>$e->getMessage()]);
    exit();
}

// LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
    $dati = json_decode(file_get_contents("php://input"), true);

    if (!isset($dati['email']) || !isset($dati['password'])) {
        echo json_encode(["errore" => "Email o password mancanti"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT ID_Utente, Email, Tipo_Utente FROM utente WHERE Email = :email AND Password = :password");
    $stmt->execute([
        'email' => $dati['email'],
        'password' => $dati['password']
    ]);

    $utente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utente) {
        echo json_encode(["messaggio" => "Login riuscito", "utente" => $utente]);
    } else {
        echo json_encode(["errore" => "Credenziali non valide"]);
    }
    exit;
}

// REGISTRAZIONE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/register') {
    $dati = json_decode(file_get_contents("php://input"), true);

    if (!isset($dati['email'], $dati['password'], $dati['tipo_utente'])) {
        echo json_encode(["errore" => "Tutti i campi sono obbligatori"]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO utente (Email, Password, Tipo_Utente) VALUES (:email, :password, :tipo)");
        $stmt->execute([
            'email' => $dati['email'],
            'password' => $dati['password'],
            'tipo' => $dati['tipo_utente']
        ]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["messaggio" => "Registrazione avvenuta con successo"]);
        } else {
            echo json_encode(["errore" => "Errore durante la registrazione"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["errore" => "Errore nel database: " . $e->getMessage()]);
    }

    exit;
}
?>
