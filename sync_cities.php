foreach(\App\Models\Publication::all() as $p) {
    if($p->escort) {
        $p->city = $p->escort->city;
        $p->save();
    }
}
echo "Cities synced!\n";
