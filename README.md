
### Installation ###

* `git clone https://github.com/bestmomo/laravel5-example.git projectname`
* `cd projectname`
* `composer install`
* `php artisan key:generate`
* Create a database and inform *.env*
* `php artisan migrate --seed` to create and populate tables
* Inform *config/mail.php* for email sends
* `php artisan vendor:publish` to publish filemanager
* `php artisan serve` to start the app on http://localhost:8000/

Another cool way to install it is to upload [this package](http://laravel.sillo.org/tuto/installable.zip), unpack it in your server folder, and just launch it and follow the installation windows. It has been created with my [laravel installer package](https://github.com/bestmomo/laravel-installer). Anyway you'll have to set the email configuration.



### Features ###

* Home page
* Custom Error Page 404
* Authentication (login, logout)
* Order Report : View order reports on d3 graph.
* Search Orders

### Tricks ###

To test application the database is seeding with users :

* Administrator : email = ajaym.synsoft@gmail.com, password = Synsoft@123

