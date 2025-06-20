## Livewire

don't forget to copy the env, using the default sqlite is fine,
then,

just do

```
composer install
npm i
php artisan migrate --seed
```

and run

```
php artisan serve
```

and also run this in parallel

```
npm run dev
```

and you get:
![livewiredemo](public/livewire.gif)
