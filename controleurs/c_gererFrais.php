<?php
/*
 * Gestion des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

 /*
 * Pour générer une fiche de frais on a besoin de l'id du visiteur
 * On le stocke dans la variable $idVisiteur issue de la variable
 * du tableau session généré à l'authentification
 */
$idVisiteur = $_SESSION['idVisiteur'];// récupérer les données de la session

// la fonction date renvoie la date du jour

$mois = getMois(date('d/m/Y'));

 /* 
 * la fonction substr retourne une partie de la chaine de caractères
 * extrait les 4 premiers caractères de la chaîne de caractères $mois qui représentent l'année
 * extrait 2 caractères à partir de la position 4 dans la chaîne de caractères $mois qui représentent les chiffres du mois.
 */

$numAnnee = substr($mois, 0, 4);

$numMois = substr($mois, 4, 2);

//lit l'action dans l'url(input_get) et le stocke dans la variable $action

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'saisirFrais':
    // PDO = requete SQL : va donc se connecter à la base de données pour voir si il possède une fiche de frais 
    if ($pdo->estPremierFraisMois($idVisiteur, $mois)) { // si il trouve une fiche de frais
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);// crée
    }
    break;
case 'validerMajFraisForfait':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_SANITIZE_STRING);
    $lesFrais = $_POST['lesFrais'];
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }
    break;
case 'validerCreationFrais':
    $dateFrais = filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_STRING);// dateFrais récupérée grace à l'attribut name de input
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    valideInfosFrais($dateFrais, $libelle, $montant);
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->creeNouveauFraisHorsForfait(
            $idVisiteur,
            $mois,
            $libelle,
            $dateFrais,
            $montant
        );
    }
    break;
case 'supprimerFrais':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $pdo->supprimerFraisHorsForfait($idFrais);
    break;
}

 /* 
 * Cette fonction renvoie un tableau contenant les éléments remboursables
 * pour le visiteur en question 
 */

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
require 'vues/v_listeFraisForfait.php';
require 'vues/v_listeFraisHorsForfait.php';