<?php
class DrugStatsController {
    private $drugStatsModel;
    public function __construct() {
        $this->drugStatsModel = new DrugStats();
    }
    public function getStatsByYear($year) {
        $stats = $this->drugStatsModel->getStatsByYear($year);
        // Logica pentru afișarea sau returnarea datelor
    }
}
//Implementează logica de afișare a datelor, generarea rapoartelor și gestionarea cererilor API.


/*1.GET
Pentru a prelua date. De exemplu, obținerea statisticilor despre consumul de droguri pentru un anumit an.
<?php
public function getStatsByYear($year) {
    // Logica pentru preluarea și returnarea datelor pentru anul specificat
}
    
2. POST
Pentru a trimite sau a crea noi date. De exemplu, adăugarea unui nou set de date statistice.
<?php
public function addDrugData($data) {
    // Logica pentru adăugarea datelor noi
}
    3. PUT/PATCH
Pentru a actualiza date existente. De exemplu, actualizarea datelor statistice pentru un anumit an.
<?php
public function updateDrugData($year, $data) {
    // Logica pentru actualizarea datelor
}


4. DELETE
Pentru a șterge date. De exemplu, ștergerea unui set de date statistice.
<?php
public function deleteDrugData($year) {
    // Logica pentru ștergerea datelor
}

<?php
public function getStats($year) {
    // Verifică dacă $year este valid
    // Interoghează modelul pentru a obține datele
    // Returnează datele în formatul solicitat (de exemplu, JSON)
}
*/