<?php

use EllipticMarketing\Larasapien\Http\Controllers\MonitoringController;

Route::post('_larasapien', MonitoringController::class)->name('larasapien.index');
