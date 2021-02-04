<?php

Route::get(config('docker-health-check.route'), fn() => 'okay');