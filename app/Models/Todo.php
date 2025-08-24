<?php
/**
 * @property \App\Models\User $user
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// teszteléshez adatokat generáló trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed',
    ];

    // automatikusan átalakítja az adatbázisból lekért értékeket PHP típusokká és viszont
    protected $casts = [
        'completed' => 'boolean',
    ];

    //Minden Todo elemhez egy User tartozik (több Todo is lehet egy Userhez)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
