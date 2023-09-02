<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchedLesson extends Model
{
    use HasFactory;

    protected $factory = WatchedLessonFactory::class;
}
