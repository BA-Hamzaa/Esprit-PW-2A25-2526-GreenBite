Module Blog & Articles — GreenBite
CRUD
Gestion des articles (entité 1)
L'utilisateur peut soumettre un article depuis le front-office en remplissant un formulaire (titre, contenu, nom, rôle, code PIN à 4 chiffres). L'article est automatiquement enregistré avec le statut en attente et ne s'affiche pas publiquement tant que l'administrateur ne l'a pas validé. L'administrateur dispose d'un back-office complet pour ajouter, modifier, supprimer et publier les articles. Il peut également consulter les articles en attente de validation dans un onglet dédié.
Gestion des commentaires (entité 2)
L'utilisateur peut commenter un article publié depuis sa page de détail. Le commentaire est enregistré avec le statut en attente et nécessite une validation de l'administrateur avant d'être visible. L'administrateur peut valider ou supprimer chaque commentaire depuis le back-office.
Mes activités (espace personnel utilisateur)
L'utilisateur accède à son espace personnel via le bouton Mes activités en saisissant son nom et son code PIN. Il peut y consulter l'historique de tous ses articles et commentaires avec leur statut respectif. Il peut modifier ou supprimer ses articles — toute modification remet l'article en attente de validation. Il peut également modifier ou supprimer ses propres commentaires.
Système de likes et dislikes
Les utilisateurs peuvent liker ou disliker les articles et les commentaires directement depuis le front-office. Les réactions sont enregistrées localement pour éviter les doublons.
Signalement et bannissement
Un utilisateur peut signaler un commentaire inapproprié depuis le front-office. Le commentaire passe alors au statut signalé et apparaît comme tel dans le back-office. L'administrateur a trois options : supprimer le commentaire et bannir l'auteur (par nom et PIN), ce qui lui interdit de soumettre de nouveaux articles ou commentaires ; ou ignorer le signalement et repasser le commentaire au statut validé.

Métiers simples
Recherche — disponible en front-office (articles publiés par titre, contenu ou auteur) et en back-office (tous les articles par titre ou auteur). La recherche se déclenche en appuyant sur Entrée.
Tri — dans le back-office, l'administrateur peut trier les articles par date d'ajout (plus récent ou plus ancien) ou par nombre de commentaires (croissant ou décroissant).
Filtrage par statut — dans le back-office, l'administrateur peut filtrer les articles par statut : Tous, Publiés, En attente ou Brouillons. Les compteurs sur chaque onglet affichent le nombre réel d'articles par catégorie.
Pagination — dans le front-office, les articles publiés sont affichés par groupes de 6 avec une navigation par numéros de page et boutons Précédent / Suivant.
