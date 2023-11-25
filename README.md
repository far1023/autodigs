1. Clone this repo to your local machine

```bash
$ git clone https://github.com/far1023/autodigs.git
```

2. Generate all depedencies by:

```bash
$ composer install
```

3. Rename `env.example` to `.env` and configure:

```bash
DB_DATABASE=your_db_name_goes_here
DB_USERNAME=your_username_goes_here
DB_PASSWORD=your_password_goes_here
```

4. Generate laravel project key:

```bash
$ php artisan key:generate
```

5. Do database migrate

```bash
$ php artisan migrate --seed
```

6. run local development server

```bash
$ php artisan serve
#and pray
```

please note this AdminLTE has been configured using [iziToast](https://izitoast.marcelodolza.com/) and [line-awesome](https://icons8.com/line-awesome/howto). If you are planning to use it too, you have to download or install it separately. See how to configure template config [here](https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration).

if something goes wrong please visit these awesome projects:

-   [Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE)
-   [Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
