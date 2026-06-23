.PHONY: build install deploy

# Builder les assets localement
build:
	npm install
	npm run build

# Déploiement vers o2switch
deploy:
	ssh qaba2231@gesticom.globalnumeric.com 'cd ~/sites/gesticom.globalnumeric.com && \
		git pull origin main && \
		composer install --no-dev --optimize-autoloader && \
		cp -n .env.example .env.production || true && \
		cp .env.production .env && \
		php artisan key:generate --force && \
		php artisan migrate --force && \
		php artisan config:cache && \
		php artisan route:cache && \
		php artisan view:cache && \
		php artisan storage:link && \
		chmod -R 775 storage bootstrap/cache && \
		echo "Déploiement terminé !"'

# Première installation
install:
	ssh qaba2231@gesticom.globalnumeric.com 'cd ~/sites/gesticom.globalnumeric.com && \
		composer install --no-dev --optimize-autoloader && \
		cp -n .env.production .env && \
		php artisan key:generate --force && \
		php artisan migrate --force && \
		php artisan db:seed --force && \
		php artisan config:cache && \
		php artisan route:cache && \
		php artisan view:cache && \
		php artisan storage:link && \
		chmod -R 775 storage bootstrap/cache && \
		echo "Installation terminée !"'
