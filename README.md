# zges_app

```sh
git clone git@github.com:piojas/zges_app.git
cd zges_app
composer install
bin/console make:migration
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
symfony server:start
```
