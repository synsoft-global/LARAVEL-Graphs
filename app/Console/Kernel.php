<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB, Log;
use App\Http\Controllers\web\ExportsController;
use App\Http\Controllers\Api\SyncDatabaseController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */

    protected $commands = [
                 
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
             

       /*$schedule->call(function () {
             $sync= new SyncDatabaseController();
           $sync->add_user_wp();  
              Log::warning('Cron add_user_wp');                 
        })->cron('* * * * *');*/

     

        /**
        * Run daily group by resources meta in store setting table.
        */
        $schedule->call(function () {
            ExportsController::get_value_groupby();  
             Log::warning('Cron get_value_groupby');          
        })->daily();

        /**
        * Run monthly job and check & delete x days older folder in fila_managment.
        */
        $schedule->call(function () {
           ExportsController::check_delete_export_dir(); 
            Log::warning('Cron get_value_groupby');          
        })->monthly();

        /**
        * Run every ten minutes job and email export report.
        */
        $schedule->call(function () {
            ExportsController::export_recurring();  
             Log::warning('Cron export_recurring');             
        })->everyTenMinutes();

        /**
        * Run hourly job and check if any pending data sync in remote wordpress site.
        */
        $schedule->call(function () {
             $sync= new SyncDatabaseController();
             $sync->check_failed_pending();  
              Log::warning('Cron check_failed_pending');          
        })->hourly(); 

        /**
        * Run hourly job and check if any pending data sync in remote wordpress site.
        */
        $schedule->call(function () {
             $sync= new SyncDatabaseController();
             $sync->woocommerce_allowed_countries();  
              Log::warning('Cron woocommerce_allowed_countries');          
        })->hourly();

        /**
        * Run hourly job and check if any pending data sync in remote wordpress site.
        */
        $schedule->call(function () {
             $sync= new SyncDatabaseController();
             $sync->get_user_roles();  
              Log::warning('Cron get_user_roles');          
        })->daily();
            
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {

        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
