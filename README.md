.env.example --> .env 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appdev
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=labers.email@gmail.com
MAIL_PASSWORD=clxekcbqgfwzkzvv
MAIL_FROM_ADDRESS=labers.email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

VsCode Terminal
cd labers-main\Appdev
composer install
npm install
php artisan migrate
php artisan db:seed
php artisan key:generate
php artisan config:clear
php artisan config:cache
php artisan storage:link
composer run dev
