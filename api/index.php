<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$host = "localhost";
$dbname = "school";
$username = "root";
$password = "root";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo json_encode(["error"=>$e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
    $dati = json_decode(file_get_contents("php://input"), true);

    if (!isset($dati['email']) || !isset($dati['password'])) {
        echo json_encode(["errore" => "Email o password mancanti"]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT ID_Utente, Nome, Cognome, Username FROM Utente WHERE Username = :username AND Password = :password");
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

    } catch (PDOException $e) {
        echo json_encode(["errore" => $e->getMessage()]);
    }

    exit;
}



?>




