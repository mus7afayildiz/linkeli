<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : 
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
