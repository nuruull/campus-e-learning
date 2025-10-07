<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model
{
  use HasFactory, HasSlug;

  protected $fillable = [
    'name',
    'description',
    'lecturer_id',
  ];

  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
      ->generateSlugsFrom('name')
      ->saveSlugsTo('slug');
  }

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function lecturer()
  {
    return $this->belongsTo(User::class, 'lecturer_id');
  }

  public function materials()
  {
    return $this->hasMany(Material::class, 'course_id');
  }

  public function assignments()
  {
    return $this->hasMany(Assignment::class);
  }

  public function discussions()
  {
    return $this->hasMany(Discussion::class);
  }

  public function students()
  {
    return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
  }
}
