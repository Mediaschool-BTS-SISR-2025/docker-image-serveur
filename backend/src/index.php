<?php
/**
 * Fichier de test de l'API Backend pour MediaSchool
 */

// ✅ ÉTAPE 1 : Autoriser l'accès depuis d'autres origines (CORS)
// C'est la ligne la plus importante : elle autorise ton site sur localhost:3000
// à communiquer avec ce serveur sur localhost:9000.
header("Access-Control-Allow-Origin: *");

// ⚙️ ÉTAPE 2 : Définir le type de contenu de la réponse
// On indique au navigateur qu'on lui envoie du JSON.
header("Content-Type: application/json; charset=UTF-8");

// 💡 ÉTAPE 3 : Préparer la réponse
// On crée un tableau PHP qui sera converti en JSON.
$response = [
    'status' => 'success',
    'message' => '✅ Bravo, le backend MediaSchool fonctionne parfaitement !',
    'timestamp' => date('Y-m-d H:i:s') // On ajoute l'heure pour montrer que c'est dynamique
];

// 🚀 ÉTAPE 4 : Envoyer la réponse
// On encode le tableau en JSON et on l'affiche.
echo json_encode($response);

?>