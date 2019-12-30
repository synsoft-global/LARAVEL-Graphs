<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money1', function ($amount) {
            $currency=get_currency_symbol(session('store_currency'));
            return "<?php echo '$currency'.number_format($amount, 2); ?>";
        });

        Blade::directive('money_decimal1', function ($amount) {
            $currency=get_currency_symbol(session('store_currency'));
            return "<?php echo '$currency'.number_format($amount); ?>";
        });

        Blade::directive('money_decimal_one1', function ($amount) {
            $currency=get_currency_symbol(session('store_currency'));
            return "<?php echo '$currency'.number_format($amount,1); ?>";
        });

        Blade::directive('number1', function ($amount) {
            return "<?php echo number_format($amount, 0); ?>";
        });

        Blade::directive('number_decimal1', function ($amount) {
            return "<?php echo number_format($amount, 1); ?>";
        });

         Blade::directive('number_decimal_2', function ($amount) {
            return "<?php echo number_format($amount, 2); ?>";
        });

        Blade::directive('perchanges1', function ($amount) {

            return "<?php echo ($amount > 0) ? '<span class=green>+'.round($amount).'%</span>' : '<span class=red>'.round($amount).'%</span>'; ?>";
        });
        
        Blade::directive('perchanges_avg1', function ($amount) {

            return "<?php echo ($amount > 0) ? '<span class=green>+'.round($amount,1).'%</span>' :  ((($amount < 0)) ? '<span class=red>'.round($amount,1).'%</span>' : '<span>'.round($amount,1).'%</span>'); ?>";
        });

        Blade::directive('perchanges_avg_revenue1', function ($amount) {

            return "<?php ($amount == 0) ? '<span class=>+'.round($amount,1).'%</span>' : (($amount > 0) ? '<span class=postive>+'.round($amount,1).'%</span>' : '<span class=negative>'.round($amount,1).'%</span>'); ?>";
        });
        Blade::directive('datetime1', function ($date) {
            return "<?php echo date('F j, Y \a\\t H:i A', strtotime($date)); ?>";
        });
    }
}
