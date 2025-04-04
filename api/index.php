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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/register') {
    $dati = json_decode(file_get_contents("php://input"), true);

    // Controllo che tutti i dati siano presenti
    if (!isset($dati['nome'], $dati['cognome'], $dati['data_nascita'], $dati['indirizzo'], $dati['telefono'], $dati['email'], $dati['password'])) {
        echo json_encode(["errore" => "Tutti i campi sono obbligatori"]);
        exit;
    }

    // Hash della password per maggiore sicurezza
    $passwordHash = password_hash($dati['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO Anagrafica (Nome, Cognome, Data_Nascita, Indirizzo, Telefono, Email) 
                               VALUES (:nome, :cognome, :data_nascita, :indirizzo, :telefono, :email)
                               INSERT INTO Utente (Username, Password)
                               VALUES (:username, :password)");

        $stmt->execute([
            'nome' => $dati['nome'],
            'cognome' => $dati['cognome'],
            'data_nascita' => $dati['data_nascita'],
            'indirizzo' => $dati['indirizzo'],
            'telefono' => $dati['telefono'],
            'email' => $dati['email'],
            'password' => $passwordHash
        ]);

        // Controlliamo se la registrazione è andata a buon fine
        if ($stmt->rowCount() > 0) {
            echo json_encode(["messaggio" => "Registrazione avvenuta con successo!"]);
        } else {
            echo json_encode(["errore" => "Errore durante la registrazione"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["errore" => "Errore nel database: " . $e->getMessage()]);
    }

    exit;
}



?>




