$e = App\Models\Escort::find(3);
if($e) {
    $photos = [];
    for($i=0; $i<9; $i++) {
        $photos[] = 'https://ui-avatars.com/api/?name=' . Illuminate\Support\Str::random(5) . '&background=random&size=512';
    }
    $e->photos = $photos;
    $e->save();
    echo "Updated Escort 3 Photos successfully.\n";
} else {
    echo "Escort 3 not found.\n";
}
exit();
