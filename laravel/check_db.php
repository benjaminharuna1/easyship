<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Shipments and their history coverage ===\n";
foreach (DB::table('addtracking')->get(['tracking_id']) as $r) {
    $hist = DB::table('shipment_history')->where('tracking_id', $r->tracking_id)->count();
    $tu = DB::table('track_update')->where('track_num', $r->tracking_id)->count();
    $flag = ($hist === 0 && $tu === 0) ? '  <-- NO HISTORY AT ALL' : (($hist === 0) ? '  <-- history in track_update only' : '');
    echo $r->tracking_id . ' : shipment_history=' . $hist . ', track_update=' . $tu . $flag . PHP_EOL;
}

echo "\n=== track_update with no matching shipment_history (for shipped items) ===\n";
foreach (DB::table('track_update')->get(['track_num']) as $r) {
    $hist = DB::table('shipment_history')->where('tracking_id', $r->track_num)->count();
    echo $r->track_num . ' : shipment_history=' . $hist . PHP_EOL;
}

echo "\n=== sample track_update rows ===\n";
foreach (DB::table('track_update')->get(['track_num','status','date','time','note','current_location']) as $r) {
    echo $r->track_num . ' | ' . $r->date . ' ' . $r->time . ' | ' . $r->status . ' | ' . $r->current_location . ' | ' . $r->note . PHP_EOL;
}
