<?php


$articlesLogs = "articles_logs.json";

// * I check if the file exists w/ function file_exists(string $filename): bool

if(!file_exists($articlesLogs)){
    exit("Le fichier n'existe pas");
}

// * If the file exists, I read it with file_get_contents() and store it

$dataLogs = file_get_contents($articlesLogs);

// * Check if reading succeeded

if($dataLogs === false){
    exit("Impossible de lire le fichier $articlesLogs");
}

// * Decodes a JSON string w/ json_decode()
// ** When true, returns an associative arrays; when false,returns an objects. When null, (to reead).

$logs = json_decode($dataLogs, true);

// * Check if decode = success
if($logs === null){
    exit("Erreur lors du décodage des logs JSON.");
}


// * I need to get new addition, modification, deletion
// ********************************
// * Function to register changes *
// ********************************

function registerLog (string $logs, array $datas){
    $logs [
        
    ]
}





// *****************************
// * Function to display datas *
// *****************************
function display_logs(array $logs)
{
    echo "<div style='border:1px solid #ccc; margin:10px; padding:10px;'>";
    echo "<strong style='background-color:#FF0; padding:5px;'> " . htmlspecialchars($logs['timestamp']) . "</strong><br>";
    echo "<strong>Action :</strong> " . htmlspecialchars($logs['action']) . "<br>";
    echo "<strong>IP :</strong> " . htmlspecialchars($logs['ip']) . "<br>";
    echo "<strong>User Agent :</strong> " . htmlspecialchars($logs['user_agent']) . "<br>";

    // Afficher les données supplémentaires
    echo "<strong>Données :</strong><pre>" . htmlspecialchars(json_encode($logs['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "</pre>";
    echo "</div>";
}

// Afficher chaque log dans le navigateur
echo "<h1>Logs</h1>";
foreach ($logs as $log) {
    display_logs($log);
}


?>

<?php  include __DIR__.'/../components/header.php'; ?>


<?php  include __DIR__.'/../components/footer.php'; ?>