<?php
$pdo = new PDO('mysql:host=localhost;dbname=nutrigreen', 'root', '');
// Align all testing regimes to the latest typed name 'smss' so they all appear again
$pdo->exec("UPDATE regime_alimentaire SET soumis_par = 'smss'");
echo "DB Updated.";
