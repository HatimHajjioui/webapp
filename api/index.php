<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
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

    $stmt = $pdo->prepare("SELECT ID_Utente, Email, ID_Ruolo FROM utente WHERE Email = :email AND Password = :password");
    $stmt->execute([
        'email' => $dati['email'],
        'password' => $dati['password']
    ]);

    $utente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utente) {
        // Aggiungi questa parte per ottenere l'ID_Studente
        $additionalData = [];
        if ($utente['ID_Ruolo'] == 3) { // Studente
            $stmt = $pdo->prepare("SELECT ID_Studente FROM studente WHERE ID_Anagrafica = 
                              (SELECT ID_Anagrafica FROM utente WHERE ID_Utente = ?)");
            $stmt->execute([$utente['ID_Utente']]);
            $studenteData = $stmt->fetch(PDO::FETCH_ASSOC);
            $additionalData['ID_Studente'] = $studenteData['ID_Studente'];
        }

        echo json_encode([
            "messaggio" => "Login riuscito",
            "utente" => array_merge($utente, $additionalData)
        ]);
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
            $stmt3 = $pdo->prepare("INSERT INTO utente (Email, Password, ID_Ruolo, ID_Studente) 
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

            $stmt3 = $pdo->prepare("INSERT INTO utente (Email, Password, ID_Ruolo, ID_Docente) 
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

            $stmt3 = $pdo->prepare("INSERT INTO utente (Email, Password, ID_Ruolo, ID_Docente) 
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

// ENDPOINT PER DATI STUDENTE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/studenti\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $studenteId = $matches[1];

    try {
        // Recupera dati anagrafici e classe
        $stmt = $pdo->prepare("
            SELECT a.*, c.Nome_Classe AS classe, c.Anno_Scolastico AS anno, i.Nome AS indirizzo_studio 
            FROM studente s
            JOIN anagrafica a ON s.ID_Anagrafica = a.ID_Anagrafica
            JOIN classe c ON s.ID_Classe = c.ID_Classe
            JOIN indirizzo i ON c.ID_Indirizzo_Studio = i.ID_Indirizzo
            WHERE s.ID_Studente = ?
        ");
        $stmt->execute([$studenteId]);
        $studente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($studente) {
            echo json_encode($studente);
        } else {
            echo json_encode(["errore" => "Studente non trovato"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["errore" => $e->getMessage()]);
    }
    exit;
}

// ENDPOINT PER MATERIE STUDENTE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/studenti\/(\d+)\/materie$/', $_SERVER['REQUEST_URI'], $matches)) {
    $studenteId = $matches[1];
    header('Content-Type: application/json');

    try {
        $stmt = $pdo->prepare("
            SELECT m.ID_Materia, m.Nome AS nome_materia
            FROM insegnamento i
            JOIN materia m ON i.ID_Materia = m.ID_Materia
            JOIN classe c ON i.ID_Classe = c.ID_Classe
            JOIN studente s ON c.ID_Classe = s.ID_Classe
            WHERE s.ID_Studente = ?
            ORDER BY m.Nome_Materia
        ");
        $stmt->execute([$studenteId]);
        $materie = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Restituisci sempre un oggetto con proprietà 'data'
        echo json_encode([
            'success' => true,
            'data' => $materie ?: [],
            'message' => count($materie) ? 'Materie trovate' : 'Nessuna materia trovata'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'data' => [],
            'message' => 'Errore nel database: ' . $e->getMessage()
        ]);
    }
    exit;
}

// ENDPOINT PER VOTI STUDENTE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/studenti\/(\d+)\/voti$/', $_SERVER['REQUEST_URI'], $matches)) {
    $studenteId = $matches[1];

    try {
        $stmt = $pdo->prepare("
            SELECT v.ID_Voto, m.Nome_Materia AS materia, 
                   CONCAT(d.Nome, ' ', d.Cognome) AS docente, 
                   v.Voto, v.Data_Voto AS data_voto
            FROM valutazione v
            JOIN materia m ON v.ID_Materia = m.ID_Materia
            JOIN docente doc ON v.ID_Docente = doc.ID_Docente
            JOIN anagrafica d ON doc.ID_Docente = d.ID_Anagrafica
            JOIN studente s ON v.ID_Studente = s.ID_Studente
            WHERE v.ID_Studente = ?
            ORDER BY v.Data_Voto DESC
        ");
        $stmt->execute([$studenteId]);
        $voti = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($voti);
    } catch (PDOException $e) {
        echo json_encode(["errore" => $e->getMessage()]);
    }
    exit;
}
?>
