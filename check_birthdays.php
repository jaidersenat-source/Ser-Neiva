<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->boot();

$rows = \App\Models\Iglesia::whereNotNull('pastor_birth_date')
    ->get(['id','official_name','pastor_birth_date','municipality','department']);

if ($rows->isEmpty()) {
    echo "NO HAY IGLESIAS CON pastor_birth_date\n";
} else {
    foreach ($rows as $r) {
        $fn = $r->pastor_birth_date;
        $date = $fn instanceof \Carbon\Carbon ? $fn->format('Y-m-d') : (string)$fn;
        echo $r->id . ' | ' . $r->official_name . ' | ' . $date
            . ' | mun=' . $r->municipality
            . ' | dep=' . $r->department . "\n";
    }
}
