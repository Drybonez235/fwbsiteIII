#!/bin/bash
echo "🚀 Preparing theme for production..."

# 1. Build CSS
npx tailwindcss -i ./src/style.css -o ./dist/style.css --minify

# 2. Clean up PHP dependencies
composer install --no-dev --optimize-autoloader


echo "✅ Ready! Upload fwbsiteIII-shipping.zip to your server."
