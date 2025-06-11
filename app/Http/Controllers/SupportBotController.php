<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportBotController extends Controller
{
    public function respond(Request $request)
    {
        $question = strtolower($request->input('message', ''));

        // Réponses simples selon les mots-clés
        if (str_contains($question, 'mot de passe')) {
            $reply = "Pour réinitialiser votre mot de passe, cliquez sur 'Mot de passe oublié' sur la page de connexion et suivez les instructions.";
        } elseif (str_contains($question, 'ajouter un enfant') || str_contains($question, 'enfant')) {
            $reply = "Pour ajouter un enfant, allez dans le menu 'Ajouter Enfant', remplissez le formulaire et validez.";
        } elseif (str_contains($question, 'paiement')) {
            $reply = "Pour effectuer un paiement, rendez-vous dans la section 'Paiement' et suivez les instructions affichées.";
        } elseif (str_contains($question, 'document')) {
            $reply = "Pour déposer ou consulter un document, utilisez la section 'Documents' dans le menu principal.";
        } elseif (str_contains($question, 'notification')) {
            $reply = "Les notifications apparaissent en haut à droite. Cliquez sur la cloche pour voir les détails.";
        } elseif (str_contains($question, 'note')) {
            $reply = "Pour consulter les notes de votre enfant, allez dans la section 'Notes' après avoir sélectionné l'enfant.";
        } elseif (str_contains($question, 'contact') || str_contains($question, 'support')) {
            $reply = "Pour contacter le support, utilisez ce chat ou envoyez un email à support@adminischool.com.";
        } elseif (str_contains($question, 'déconnexion') || str_contains($question, 'logout')) {
            $reply = "Pour vous déconnecter, cliquez sur votre profil ou le bouton de déconnexion dans le menu.";
        } elseif (str_contains($question, 'dashboard') || str_contains($question, 'accueil')) {
            $reply = "Le dashboard affiche un résumé de vos informations principales dès la connexion.";
        } elseif (str_contains($question, 'enseignant')) {
            $reply = "Pour voir la liste des enseignants, allez dans la section 'Enseignants' du menu.";
        } else {
            $reply = "Je n'ai pas compris votre question. Veuillez préciser ou reformuler. Vous pouvez demander par exemple : 'Comment ajouter un enfant ?'";
        }

        return response()->json(['reply' => $reply]);
    }
}
