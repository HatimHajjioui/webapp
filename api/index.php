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

    if (!isset($dati['nome'], $dati['cognome'], $dati['data_nascita'], $dati['indirizzo'], $dati['telefono'], $dati['email'], $dati['password'], $dati['type'])) {
        echo json_encode(["errore" => "Tutti i campi sono obbligatori"]);
        exit;
    }


    try {
        // Inserimento in Anagrafica
        $stmt = $pdo->prepare("INSERT INTO anagrafica (Nome, Cognome, Data_Nascita, Indirizzo, Telefono, Email)
                               VALUES (:nome, :cognome, :data_nascita, :indirizzo, :telefono, :email)");
        $stmt->execute([
            'nome' => $dati['nome'],
            'cognome' => $dati['cognome'],
            'data_nascita' => $dati['data_nascita'],
            'indirizzo' => $dati['indirizzo'],
            'telefono' => $dati['telefono'],
            'email' => $dati['email']
        ]);

        $idAnagrafica = $pdo->lastInsertId();
        error_log("ID anagrafica" . $idAnagrafica);


        // Inserisci in Studente o Docente in base al tipo
        if ($dati['type'] === 'Studente') {
            $stmt2 = $pdo->prepare("INSERT INTO studente (ID_Anagrafica, ID_Classe) VALUES (:id, 1)");
            $stmt2->execute(['id' => $idAnagrafica]);
            $idStudente = $pdo->lastInsertId();
            $stmt3 = $pdo->prepare("INSERT INTO utente (Email, Password, Tipo_Utente, ID_Studente) 
                                    VALUES (:email, :password, :type, :id_studente)");


            $stmt3->execute([
                'email' => $dati['email'],
                'password' => $dati['password'],
                'type' => 3,
                'id_studente' => $idStudente
            ]);

            $idUtente = $pdo->lastInsertId();
            $utente = $stmt3->fetch(PDO::FETCH_ASSOC);
        } else if ($dati['type'] === 'Docente') {
            $stmt2 = $pdo->prepare("INSERT INTO docente (ID_Anagrafica) VALUES (:id)");
            $stmt2->execute(['id' => $idAnagrafica]);
            $idDocente = $pdo->lastInsertId();

            $stmt3 = $pdo->prepare("INSERT INTO utente (Email, Password, Tipo_Utente, ID_Docente) 
                                    VALUES (:email, :password, :type, :id_docente)");


            $stmt3->execute([
                'email' => $dati['email'],
                'password' => $dati['password'],
                'type' => 2,
                'id_docente' => $idDocente
            ]);
            $idUtente = $pdo->lastInsertId();
            $utente = $stmt3->fetch(PDO::FETCH_ASSOC);
        }else if ($dati['type'] === 'Amministratore') {
            $stmt2 = $pdo->prepare("INSERT INTO docente (ID_Anagrafica) VALUES (:id,1)");
            $stmt2->execute(['id' => $idAnagrafica]);
            $idAmministratore = $pdo->lastInsertId();

            $stmt3 = $pdo->prepare("INSERT INTO utente (Email, Password, Tipo_Utente, ID_Docente) 
                                    VALUES (:email, :password, :type, :id_docente)");



            $stmt3->execute([
                'email' => $dati['email'],
                'password' => $dati['password'],
                'type' => 1,
                'id_docente' => $idAmministratore
            ]);
            $idUtente = $pdo->lastInsertId();

        }

        $getUtente = $pdo->prepare("SELECT * FROM utente WHERE ID_Utente = :id");
        $getUtente->execute(['id' => $idUtente]);
        $utenteDB = $getUtente->fetch(PDO::FETCH_ASSOC);
        error_log("Utente" . $utenteDB);
        error_log("ID Utente" . $idUtente);
        echo json_encode(["messaggio" => "Registrazione avvenuta con successo!","utente" => $utenteDB]);
    } catch (PDOException $e) {
        echo json_encode(["errore" => "Errore nel database: " . $e->getMessage()]);
    }

    exit;
}
?>
