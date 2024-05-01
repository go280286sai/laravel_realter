<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'url'];
    protected $table = 'research';
    public static function add($fields): void
    {
        $data = new self();
        $data->fill($fields);
        $data->save();
    }

    /**
     * @param array $fields
     * @return void
     */
    public static function edit(array $fields): void
    {
        $data = self::find($fields['id']);
        $data->url=$fields['url'];
        $data->save();
    }
}
