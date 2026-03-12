<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->boot();

$rows = \App\Models\Iglesia::whereNotNull('fecha_nacimiento_lider')
    ->get(['id','nombre','fecha_nacimiento_lider','municipality','department']);

if ($rows->isEmpty()) {
    echo "NO HAY IGLESIAS CON fecha_nacimiento_lider\n";
} else {
    foreach ($rows as $r) {
        $fn = $r->fecha_nacimiento_lider;
        $date = $fn instanceof \Carbon\Carbon ? $fn->format('Y-m-d') : (string)$fn;
        echo $r->id . ' | ' . $r->nombre . ' | ' . $date
            . ' | mun=' . $r->municipality
            . ' | dep=' . $r->department . "\n";
    }
}
