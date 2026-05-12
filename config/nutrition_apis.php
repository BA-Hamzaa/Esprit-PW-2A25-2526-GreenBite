<?php
// ─── Nutrition & Recipe API Configuration ─────────────────────────────────────
// ⚠️  IMPORTANT: Never commit actual API keys to version control!
// =============================================

// USDA FoodData Central
// Free key: https://fdc.nal.usda.gov/api-guide.html
// DEMO_KEY works out of the box (30 req/hr, no signup needed for testing)
define('USDA_API_KEY', 'p838PdnBOL4qkTYltiH9HRpJ6TrQkzq1Cjtu41cI');
define('USDA_BASE_URL', 'https://api.nal.usda.gov/fdc/v1');

// Open Food Facts — public API, no key needed
define('OFF_BASE_URL', 'https://world.openfoodfacts.org');

// Spoonacular — Nutrition estimation
// Free key: https://spoonacular.com/food-api
define('SPOONACULAR_API_KEY', 'b3fc0d49128842d891296aa0bd1b0053');
define('SPOONACULAR_BASE_URL', 'https://api.spoonacular.com');

// TheMealDB — Recipe inspiration
// Public key "1" for free tier: https://www.themealdb.com/api.php
define('THEMEALDB_BASE_URL', 'https://www.themealdb.com/api/json/v1/1');
