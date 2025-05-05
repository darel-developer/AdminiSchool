

#!/bin/bash

# Fixer les permissions

set -e


# 1. Nettoyage des caches
# php artisan cache:clear
# php artisan config:clear
# php artisan route:clear
# php artisan view:clear

# 2. Migration (uniquement si variable d'environnement est définie)
# php artisan migrate --force

# 3. Seeders (uniquement si variable d'environnement est définie)
# php artisan db:seed --force

# 4. Redémarrage des queues
# php artisan queue:restart

php artisan storage:link
# 5. Démarrage d'Apache
exec "$@"