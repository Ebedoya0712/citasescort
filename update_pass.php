<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$u = User::where('email', 'maritzaparra070503@gmail.com')->first();
if ($u) {
    $u->password = Hash::make('12345678');
    $u->save();
    echo "Password updated\n";
} else {
    echo "User not found\n";
}
