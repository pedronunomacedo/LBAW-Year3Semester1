<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'faq';

    public static function getFAQ($id) {
        $faq = DB::table('faq')
                ->where('id', $id);
        
        return $faq;
    }

    
}
