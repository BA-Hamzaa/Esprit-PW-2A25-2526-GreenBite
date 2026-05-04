<?php
// =============================================
// GreenBite — API Keys Configuration
// =============================================
// ⚠️  IMPORTANT: Never commit actual API keys!
// Add your keys in a .env file or set environment variables
// See .env.example for the required variables

// Stripe (Test Mode)
define('STRIPE_PUBLISHABLE_KEY', getenv('STRIPE_PUBLISHABLE_KEY') ?: '');
define('STRIPE_SECRET_KEY',      getenv('STRIPE_SECRET_KEY') ?: '');

// Mapbox
define('MAPBOX_TOKEN', getenv('MAPBOX_TOKEN') ?: '');
