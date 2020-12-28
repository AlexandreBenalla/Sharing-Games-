# Sharing-Games-

J'ai fait le site seul et il y a de nombreux problèmes, j'ai d'abord essayé d'implémenter des emails de confirmation grâce à mailer et en rajoutant des variables d environnement pour me connecter au smtp de mon adresse gmail, malheuresement les mails ne s'envoient qu'en console

quand on se connecte on est redirigé vers la mauvaise page d'acceuil il faut reclicker sur sharing games dans le header pour pouvoir l'atteindre, cette page affiche l'ensembles des articles avec un bouton pour les voir dans le détail, malheuresement bien que j'ai mis un paramètre user en paramètres sur ma fonction pour afficher un article Doctrine n'arrive pas à le lier à l'utilisateur courant et donc il ne peut pas vérifier si il est connécté avec le createur de l'artile en question ou non ce qui fait qu'il execute un genre de form au lieu d'afficher le contenu, ce probleme fait que la page de profil est bugguée aussi, on peut y accéder en tapant l'url et l'id du profil associé et normalement il permet de modifier les parametres du compte en fournissant un formulaire prérempli avec les données actuelles du profil , le twig y est configuré pour ne pas afficher le formulaire si on est pas connécté.

l'inscription et la déconnexion marchent sans problème
je n'ai pas eu le temps d'implémenter une barre de recherche cependant j'ai crée toutes les entités nécéssaires pour le faire avec les relations associées

la création d'article est fonctionelle est nécéssite deux liens: un pour une image et l'autre pour accéder au téléchargement, je m'étais attelé à la gestion de fichiers que j'arrivais d'ailleurs à récuperer et enregistrer dans un dossier prévu à cet effet, mais meme en codant en brut le chemin vers les images elles ne daignaient pas s'afficher, j'ai donc abandonné
j'avais presque réussi à implémenter des commentaires mais j'ai bloqué sur une erreur de symfony et n'ai pas trouvé de solution
j'ai 4 entités : User , Article , Category, Comment

il est possible que les migrations capotent car j'ai du légérement les modifier pour qu'elles se lancent sur mon phpmyadmin, apparement à cause d'un probleme de version de php.
