<?php
require_once('Db.php'); // Asigură-te că calea către fișierul Db.php este corectă

$db = new DB();
echo $db->isConnected();

$sql = "SELECT * FROM confiscari_droguri";
try {
    // Presupunând că există o metodă getPdo() în clasa DB care returnează obiectul PDO
    $stmt = $db->getPdo()->query($sql);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($stats)) {
        echo "No drugs found.";
    } else {
        echo "Drugs fetched successfully.";
        echo "Lista medicamentelor:\n";
        echo "---------------------\n";

        foreach ($stats as $drug) {
            echo "id: " . $drug['id'] . ", drog: " . $drug['drog'] . ", grame: " . $drug['grame'] .", comprimate: " . $drug['comprimate'] . ", mililitri: " . $drug['mililitri']. ", capturi: " . $drug['capturi'] .", an: " . $drug['an'] ."\n";
        }
    }
    return $stats;
} catch (PDOException $e) {
    echo "Error fetching drugs: " . $e->getMessage();
    return null;
}