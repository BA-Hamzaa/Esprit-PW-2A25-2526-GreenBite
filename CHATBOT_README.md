# Chatbot NutriGreen

## 📋 Description

Le chatbot NutriGreen est un assistant virtuel intégré à l'application qui aide les utilisateurs à naviguer et à obtenir des informations sur les services de NutriGreen.

## ✨ Fonctionnalités

- **Widget flottant** : Bouton de chat accessible en bas à droite de toutes les pages
- **Réponses intelligentes** : Système basé sur des mots-clés pour des réponses pertinentes
- **Suggestions automatiques** : Propositions de questions fréquentes
- **Interface moderne** : Design responsive et animé
- **Typing indicator** : Animation de frappe pour une expérience utilisateur réaliste

## 🚀 Installation

Le chatbot est déjà intégré dans le layout principal (`front_header.php`) et apparaît automatiquement sur toutes les pages utilisant ce layout.

## 📁 Structure des fichiers

```
GREENBITE/
├── config/
│   └── chatbot.php              # Configuration et réponses du chatbot
├── app/
│   ├── controllers/
│   │   └── ChatbotController.php  # Contrôleur pour les requêtes API
│   ├── views/
│   │   ├── api/
│   │   │   └── chatbot.php        # Point d'entrée API
│   │   ├── components/
│   │   │   └── chatbot_widget.php # Widget de chat (HTML/CSS/JS)
│   │   └── layouts/
│   │       └── front_header.php   # Layout principal (inclut le widget)
```

## 🔧 Configuration

### Modifier les réponses du chatbot

Ouvrez `config/chatbot.php` et modifiez le tableau `$chatbotResponses` :

```php
$chatbotResponses = [
    'mot-clé' => [
        'response' => 'Votre réponse ici',
        'suggestions' => ['Suggestion 1', 'Suggestion 2', 'Suggestion 3']
    ],
    // ... autres réponses
];
```

### Ajouter de nouvelles réponses

1. Ajoutez une nouvelle entrée dans le tableau `$chatbotResponses` :
```php
'nouveau-mot-clé' => [
    'response' => 'Nouvelle réponse',
    'suggestions' => ['Suggestion 1', 'Suggestion 2']
],
```

2. Le mot-clé sera automatiquement détecté dans les messages des utilisateurs.

### Modifier les suggestions populaires

Modifiez la fonction `getChatbotSuggestions()` dans `config/chatbot.php` :

```php
function getChatbotSuggestions() {
    return [
        'Question 1',
        'Question 2',
        'Question 3',
        // ... ajoutez vos suggestions
    ];
}
```

## 🎨 Personnalisation

### Changer les couleurs

Modifiez les styles CSS dans `app/views/components/chatbot_widget.php` :

```css
/* Couleur principale */
.chatbot-toggle {
  background: linear-gradient(135deg, var(--primary) 0%, #1B4332 100%);
}

/* Couleur des messages utilisateur */
.chatbot-message.user {
  background: var(--primary);
}
```

### Changer la position du widget

Modifiez les styles CSS du widget :

```css
.chatbot-widget {
  position: fixed;
  bottom: 2rem;    /* Distance du bas */
  right: 2rem;     /* Distance de la droite */
  /* Pour gauche : left: 2rem; */
}
```

### Changer l'avatar du chatbot

Modifiez l'icône dans le header du widget :

```html
<div class="chatbot-avatar">
  <i data-lucide="leaf"></i>  <!-- Changez l'icône ici -->
</div>
```

## 📱 Utilisation

### Pour les utilisateurs

1. Cliquez sur le bouton de chat en bas à droite de l'écran
2. Tapez votre question ou cliquez sur une suggestion
3. Le chatbot répondra automatiquement
4. Vous pouvez continuer la conversation

### Pour les développeurs

#### API Endpoints

**Obtenir une réponse**
```
POST /?page=api-chatbot&action=response
Content-Type: application/json

{
  "message": "votre message"
}
```

**Réponse**
```json
{
  "success": true,
  "response": "Réponse du chatbot",
  "suggestions": ["Suggestion 1", "Suggestion 2"]
}
```

**Obtenir les suggestions**
```
GET /?page=api-chatbot&action=suggestions
```

**Réponse**
```json
{
  "success": true,
  "suggestions": ["Suggestion 1", "Suggestion 2", ...]
}
```

## 🎯 Mots-clés actuels

Le chatbot répond aux mots-clés suivants :

- **Salutations** : bonjour, salut, hello
- **Compte** : compte, inscription, connexion, mot de passe
- **Services** : services, nutrition, marketplace, recettes
- **À propos** : propos, mission
- **Contact** : aide, contact, support
- **Autres** : merci, au revoir

## 🔍 Dépannage

### Le widget n'apparaît pas

1. Vérifiez que le layout `front_header.php` est inclus dans votre page
2. Vérifiez que le fichier `chatbot_widget.php` existe
3. Vérifiez les erreurs JavaScript dans la console du navigateur

### Le chatbot ne répond pas

1. Vérifiez que le fichier `api/chatbot.php` existe
2. Vérifiez que le contrôleur `ChatbotController.php` existe
3. Vérifiez les erreurs réseau dans les outils de développement du navigateur

### Les réponses ne sont pas pertinentes

1. Vérifiez les mots-clés dans `config/chatbot.php`
2. Ajoutez de nouveaux mots-clés si nécessaire
3. Modifiez les réponses existantes pour mieux correspondre aux besoins

## 🚀 Améliorations futures

Voici quelques idées pour améliorer le chatbot :

- [ ] Intégration avec une API d'IA (OpenAI, etc.)
- [ ] Historique des conversations
- [ ] Base de connaissances extensible
- [ ] Analytics sur les questions posées
- [ ] Support multilingue
- [ ] Notifications push pour les réponses différées

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.

---

**Dernière mise à jour** : 6 mai 2026
