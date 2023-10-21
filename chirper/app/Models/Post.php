<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\PostCreated;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use HasTranslations;

    public $translatable = ['description'];

    protected $fillable = [
        'description',
        'image',
        'user_id',
    ];

    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function getImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia("post_image");
        return $media?->getUrl($media->hasGeneratedConversion('original') ? 'original' : '');
    }

    public function getImageThumbAttribute(): ?string
    {
        $media = $this->getFirstMedia("post_image");
        return $media?->getUrl();
    }

}
