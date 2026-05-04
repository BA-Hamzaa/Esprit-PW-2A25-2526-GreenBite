<?php
// ─── Nutrition API Configuration ──────────────────────────────────────────────
// USDA FoodData Central — get free key at: https://fdc.nal.usda.gov/api-guide.html
// DEMO_KEY works out of the box (30 req/hr, no signup needed for testing)
// ⚠️  Add your API keys to .env file, never commit them!
define('USDA_API_KEY', getenv('USDA_API_KEY') ?: 'DEMO_KEY');

// Open Food Facts — no key needed (public API)
define('OFF_BASE_URL', 'https://world.openfoodfacts.org');
define('USDA_BASE_URL', 'https://api.nal.usda.gov/fdc/v1');
