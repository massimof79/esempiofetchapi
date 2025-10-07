<?php
// server.php

// Imposta l'header per le risposte JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

// Verifica che sia una richiesta POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Leggi i dati JSON dal corpo della richiesta
    $json = file_get_contents('php://input');
    $dati = json_decode($json, true);
    
    // Valida i dati ricevuti
    if (!isset($dati['nome']) || !isset($dati['email'])) {
        http_response_code(400);
        echo json_encode([
            'successo' => false,
            'messaggio' => 'Dati incompleti'
        ]);
        exit;
    }
    
    $nome = htmlspecialchars($dati['nome']);
    $email = htmlspecialchars($dati['email']);
    
    // Valida l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode([
            'successo' => false,
            'messaggio' => 'Email non valida'
        ]);
        exit;
    }
    
    // Elabora i dati e restituisci la risposta
    $risposta = [
        'successo' => true,
        'messaggio' => 'Dati ricevuti con successo!',
        'nome' => $nome,
        'email' => $email,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode($risposta);
    
} else {
    
    // Se non è POST, restituisci un errore
    http_response_code(405);
    echo json_encode([
        'successo' => false,
        'messaggio' => 'Metodo non consentito'
    ]);
}
?>
