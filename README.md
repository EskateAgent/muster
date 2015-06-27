# Muster

Muster is a web application for UKRDA Member Leagues and administration staff to manage the process of digitised charter submission.

## Background

Muster is built on a vanilla install of [Laravel 5](https://github.com/laravel/laravel), with the addition of a couple of external packages:
* [Forms & HTML](http://laravelcollective.com/docs/5.1/html) by Laravel Collective
* [entrust](https://github.com/Zizaco/entrust) by Zizaco

A composer configuration is included to build the base environment, but the composer phar has not been included directly.

## Bootstrapping

The process for getting an instance of Muster up and running is a bit manual for now, unfortunately. I presume some (or all) of this can be shortened/automated, but have put zero effort into investigation and thus manual is all we have until there's more urgency for better.

Steps are as follows:

1. install and configure a hosting environment suitable for Laravel 5. The [Laravel 5 documentation](http://laravel.com/docs/5.0/installation) has all the information you need to get going
2. clone the [canonical repo](https://github.com/ukrda/muster) into a folder of your choosing
3. jump into the root directory of the project and run `composer update`
4. copy the `.env.example` file to `.env` in the same directory, and edit to taste
5. make sure that the `storage` directory (and any of it's contents) are writable by the user your httpd process runs under (eg. www-data in Ubuntu, http in Arch Linux, etc)
6. run `php artisan migrate` from the command line (*protip*: make the artisan file executable and you can just run `./artisan migrate` instead!)
7. run `php artisan db:seed` from the command line (or `./artisan db:seed` if you did the *protip* above)
8. manually inject a user record into the database. In MariaDB/MySQL this looks like:

   ```sql
   INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES (1, 'root', 'root@localhost.com', '$2y$10$BK7HykL2gNqMW9aWDZ9qr.c.dca6XQmpNLbyBA7nb5QUz3xWd7xHW', NOW(), NOW() );
   ```

9. manually marry the injected user with the `root` permission role. Again, in MariaDB/MySQL this looks like:

   ```sql
   INSERT INTO `role_user` (`user_id`, `role_id`) VALUES (1, 1);
   ```

10. fire up your browser and direct it to your new Muster instance
11. log in with the credentials:

    ```
    email address: root@localhost
    password: d6c75196
    ```

12. **immediately** change your password for this user account, or create a new root account and delete the temporary one
