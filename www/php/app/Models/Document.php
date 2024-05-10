<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['client_id', 'service_id', 'rooms', 'etajnost', 'location', 'price', 'comment'];

    public static function add(array $fields): void
    {
        $object = new self();
        $object->fill($fields);
        $object->save();
    }

    public static function edit(array $fields, string $id): void
    {
        $object = self::find($id);
        $object->fill($fields);
        $object->save();
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public static function addComment(array $fields): void
    {
        $object = self::find($fields['id']);
        $object->comment = $fields['comment'];
        $object->save();
    }

    public static function remove($id): void
    {
        $object = self::find($id);
        $object->delete();
    }
}
