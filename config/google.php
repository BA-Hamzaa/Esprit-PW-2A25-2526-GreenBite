<?php
// =============================================
// Google OAuth2 Configuration
// =============================================
// To enable Google login:
// 1. Go to https://console.cloud.google.com/
// 2. Create a project → APIs & Services → Credentials
// 3. Create OAuth 2.0 Client ID (Web application)
// 4. Add Authorized redirect URI:
//    http://localhost/GREENBITE/public/?page=google-callback
// 5. Replace the values below with your real credentials
// =============================================

define('GOOGLE_CLIENT_ID',     'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'YOUR_GOOGLE_CLIENT_SECRET');
define('GOOGLE_REDIRECT_URI',  FULL_BASE_URL . '/?page=google-callback');
