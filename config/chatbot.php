<?php
/**
 * Configuration du Chatbot NutriGreen
 * 
 * Ce fichier contient les réponses prédéfinies du chatbot basées sur des mots-clés
 */

/**
 * Réponses du chatbot
 * Format: 'mot-clé' => ['réponse', 'suggestions' => []]
 */
$chatbotResponses = [
    // Salutations
    'bonjour' => [
        'response' => 'Bonjour ! 👋 Je suis le chatbot NutriGreen. Comment puis-je vous aider aujourd\'hui ?',
        'suggestions' => ['Comment créer un compte ?', 'Quels sont les services ?', 'Comment fonctionne le suivi nutritionnel ?']
    ],
    'salut' => [
        'response' => 'Salut ! 👋 Bienvenue sur NutriGreen. En quoi puis-je vous aider ?',
        'suggestions' => ['Inscription', 'Connexion', 'Services']
    ],
    'hello' => [
        'response' => 'Hello ! 👋 Ravi de vous voir sur NutriGreen. Que souhaitez-vous savoir ?',
        'suggestions' => ['À propos', 'Fonctionnalités', 'Contact']
    ],
    
    // Inscription/Connexion
    'compte' => [
        'response' => 'Pour créer un compte, cliquez sur "Créer un compte" dans le menu. L\'inscription est gratuite et rapide ! 📝',
        'suggestions' => ['Comment se connecter ?', 'Mot de passe oublié ?', 'Modifier mon profil']
    ],
    'inscription' => [
        'response' => 'L\'inscription est simple : renseignez votre nom, email et mot de passe. Vous pourrez ensuite accéder à tous nos services ! ✨',
        'suggestions' => ['Créer un compte', 'Connexion', 'Avantages']
    ],
    'connexion' => [
        'response' => 'Pour vous connecter, utilisez votre email et mot de passe. Vous pouvez aussi utiliser Google ou Face ID ! 🔐',
        'suggestions' => ['Mot de passe oublié ?', 'Problème de connexion ?', 'Connexion Google']
    ],
    'mot de passe' => [
        'response' => 'Si vous avez oublié votre mot de passe, cliquez sur "Mot de passe oublié ?" sur la page de connexion. Vous recevrez un email pour le réinitialiser. 🔑',
        'suggestions' => ['Réinitialiser mon mot de passe', 'Changer mon mot de passe', 'Connexion']
    ],
    
    // Services/Fonctionnalités
    'services' => [
        'response' => 'NutriGreen offre plusieurs services : 🥗 Suivi nutritionnel, 🛒 Marketplace alimentaire, 📖 Recettes saines, et 👥 Une communauté engagée !',
        'suggestions' => ['Suivi nutritionnel', 'Marketplace', 'Recettes']
    ],
    'nutrition' => [
        'response' => 'Notre service de suivi nutritionnel vous permet de tracker vos repas, calculer vos calories et recevoir des conseils personnalisés ! 🥗',
        'suggestions' => ['Comment tracker mes repas ?', 'Objectifs caloriques', 'Conseils nutritionnels']
    ],
    'marketplace' => [
        'response' => 'La marketplace NutriGreen propose des produits alimentaires sains et durables. Vous pouvez trouver des fruits, légumes, et produits bio ! 🛒',
        'suggestions' => ['Comment acheter ?', 'Livraison', 'Produits disponibles']
    ],
    'recettes' => [
        'response' => 'Nous avons une large collection de recettes saines et délicieuses. Filtrer par ingrédients, temps de préparation ou régime ! 📖',
        'suggestions' => ['Recettes végétariennes', 'Recettes rapides', 'Recettes sans gluten']
    ],
    
    // À propos
    'propos' => [
        'response' => 'NutriGreen est votre compagnon intelligent pour une alimentation durable et un mode de vie sain. 🌱',
        'suggestions' => ['Notre mission', 'L\'équipe', 'Contact']
    ],
    'mission' => [
        'response' => 'Notre mission est d\'aider chacun à adopter une alimentation saine et durable, tout en préservant notre planète ! 🌍',
        'suggestions' => ['Services', 'Valeurs', 'Rejoindre la communauté']
    ],
    
    // Contact/Aide
    'aide' => [
        'response' => 'Je suis là pour vous aider ! Vous pouvez me poser des questions sur l\'utilisation de NutriGreen. 💬',
        'suggestions' => ['Problème technique', 'Suggestion', 'Contact support']
    ],
    'contact' => [
        'response' => 'Pour nous contacter, envoyez un email à support@nutrigreen.com ou utilisez le formulaire de contact. Nous répondons sous 24h ! 📧',
        'suggestions' => ['Email support', 'Formulaire contact', 'Réseaux sociaux']
    ],
    'support' => [
        'response' => 'Notre équipe support est disponible pour vous aider. Décrivez votre problème et nous trouverons une solution ! 🛠️',
        'suggestions' => ['Problème de connexion', 'Erreur technique', 'Question sur les services']
    ],
    
    // Autres
    'merci' => [
        'response' => 'Je vous en prie ! N\'hésitez pas si vous avez d\'autres questions. 😊',
        'suggestions' => ['Autre question', 'Services', 'Contact']
    ],
    'au revoir' => [
        'response' => 'Au revoir ! 👋 Bonne continuation sur NutriGreen !',
        'suggestions' => ['Revenir', 'Services', 'Contact']
    ],
    'default' => [
        'response' => 'Je n\'ai pas bien compris votre question. Pouvez-vous reformuler ? Je peux vous aider avec : compte, services, nutrition, marketplace, recettes, ou contact. 🤔',
        'suggestions' => ['Créer un compte', 'Services', 'Contact']
    ]
];

/**
 * Fonction pour obtenir une réponse du chatbot
 *
 * @param string $message Message de l'utilisateur
 * @return array ['response' => string, 'suggestions' => array]
 */
function getChatbotResponse($message) {
    $chatbotResponses = [
        // Salutations
        'bonjour' => [
            'response' => 'Bonjour ! 👋 Je suis le chatbot NutriGreen. Comment puis-je vous aider aujourd\'hui ?',
            'suggestions' => ['Comment créer un compte ?', 'Quels sont les services ?', 'Comment fonctionne le suivi nutritionnel ?']
        ],
        'salut' => [
            'response' => 'Salut ! 👋 Bienvenue sur NutriGreen. En quoi puis-je vous aider ?',
            'suggestions' => ['Inscription', 'Connexion', 'Services']
        ],
        'hello' => [
            'response' => 'Hello ! 👋 Ravi de vous voir sur NutriGreen. Que souhaitez-vous savoir ?',
            'suggestions' => ['À propos', 'Fonctionnalités', 'Contact']
        ],

        // Inscription/Connexion
        'compte' => [
            'response' => 'Pour créer un compte, cliquez sur "Créer un compte" dans le menu. L\'inscription est gratuite et rapide ! 📝',
            'suggestions' => ['Comment se connecter ?', 'Mot de passe oublié ?', 'Modifier mon profil']
        ],
        'inscription' => [
            'response' => 'L\'inscription est simple : renseignez votre nom, email et mot de passe. Vous pourrez ensuite accéder à tous nos services ! ✨',
            'suggestions' => ['Créer un compte', 'Connexion', 'Avantages']
        ],
        'connexion' => [
            'response' => 'Pour vous connecter, utilisez votre email et mot de passe. Vous pouvez aussi utiliser Google ou Face ID ! 🔐',
            'suggestions' => ['Mot de passe oublié ?', 'Problème de connexion ?', 'Connexion Google']
        ],
        'mot de passe' => [
            'response' => 'Si vous avez oublié votre mot de passe, cliquez sur "Mot de passe oublié ?" sur la page de connexion. Vous recevrez un email pour le réinitialiser. 🔑',
            'suggestions' => ['Réinitialiser mon mot de passe', 'Changer mon mot de passe', 'Connexion']
        ],

        // Services/Fonctionnalités
        'services' => [
            'response' => 'NutriGreen offre plusieurs services : 🥗 Suivi nutritionnel, 🛒 Marketplace alimentaire, 📖 Recettes saines, et 👥 Une communauté engagée !',
            'suggestions' => ['Suivi nutritionnel', 'Marketplace', 'Recettes']
        ],
        'nutrition' => [
            'response' => 'Notre service de suivi nutritionnel vous permet de tracker vos repas, calculer vos calories et recevoir des conseils personnalisés ! 🥗',
            'suggestions' => ['Comment tracker mes repas ?', 'Objectifs caloriques', 'Conseils nutritionnels']
        ],
        'marketplace' => [
            'response' => 'La marketplace NutriGreen propose des produits alimentaires sains et durables. Vous pouvez trouver des fruits, légumes, et produits bio ! 🛒',
            'suggestions' => ['Comment acheter ?', 'Livraison', 'Produits disponibles']
        ],
        'recettes' => [
            'response' => 'Nous avons une large collection de recettes saines et délicieuses. Filtrer par ingrédients, temps de préparation ou régime ! 📖',
            'suggestions' => ['Recettes végétariennes', 'Recettes rapides', 'Recettes sans gluten']
        ],

        // À propos
        'propos' => [
            'response' => 'NutriGreen est votre compagnon intelligent pour une alimentation durable et un mode de vie sain. 🌱',
            'suggestions' => ['Notre mission', 'L\'équipe', 'Contact']
        ],
        'mission' => [
            'response' => 'Notre mission est d\'aider chacun à adopter une alimentation saine et durable, tout en préservant notre planète ! 🌍',
            'suggestions' => ['Services', 'Valeurs', 'Rejoindre la communauté']
        ],

        // Contact/Aide
        'aide' => [
            'response' => 'Je suis là pour vous aider ! Vous pouvez me poser des questions sur l\'utilisation de NutriGreen. 💬',
            'suggestions' => ['Problème technique', 'Suggestion', 'Contact support']
        ],
        'contact' => [
            'response' => 'Pour nous contacter, envoyez un email à support@nutrigreen.com ou utilisez le formulaire de contact. Nous répondons sous 24h ! 📧',
            'suggestions' => ['Email support', 'Formulaire contact', 'Réseaux sociaux']
        ],
        'support' => [
            'response' => 'Notre équipe support est disponible pour vous aider. Décrivez votre problème et nous trouverons une solution ! 🛠️',
            'suggestions' => ['Problème de connexion', 'Erreur technique', 'Question sur les services']
        ],

        // Autres
        'merci' => [
            'response' => 'Je vous en prie ! N\'hésitez pas si vous avez d\'autres questions. 😊',
            'suggestions' => ['Autre question', 'Services', 'Contact']
        ],
        'au revoir' => [
            'response' => 'Au revoir ! 👋 Bonne continuation sur NutriGreen !',
            'suggestions' => ['Revenir', 'Services', 'Contact']
        ],
        'default' => [
            'response' => 'Je n\'ai pas bien compris votre question. Pouvez-vous reformuler ? Je peux vous aider avec : compte, services, nutrition, marketplace, recettes, ou contact. 🤔',
            'suggestions' => ['Créer un compte', 'Services', 'Contact']
        ]
    ];

    $message = strtolower(trim($message));
    $message = preg_replace('/[^\p{L}\s]/u', '', $message);

    foreach ($chatbotResponses as $keyword => $data) {
        if (strpos($message, $keyword) !== false) {
            return $data;
        }
    }

    return $chatbotResponses['default'];
}

/**
 * Obtenir les suggestions populaires du chatbot
 * 
 * @return array
 */
function getChatbotSuggestions() {
    return [
        'Comment créer un compte ?',
        'Quels sont les services ?',
        'Comment fonctionne le suivi nutritionnel ?',
        'Comment acheter sur la marketplace ?',
        'Où trouver les recettes ?',
        'Contact support'
    ];
}
