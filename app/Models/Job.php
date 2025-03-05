<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Arr;

class Job extends Model
{
  use HasFactory;

  protected $table = 'job_listings';
  // protected $fillable = ['employer_id', 'title', 'salary']; // can be mass assigned, using the model and the factory
  // protected $guarded = ['*']; // disables all fillables, mass assignment using the Model (NOT the factory, Job::create) will not work
  protected $guarded = []; // allow all fields by setting to an empty array

  public function employer()
  {
    return $this->belongsTo(Employer::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, foreignPivotKey: 'job_listing_id');
  }

  /*
  public static function all(): array
  {
    return [
      [
        'id' => 1,
        'title' => 'Director',
        'salary' => '$50,000'
      ],
      [
        'id' => 2,
        'title' => 'Human Programmer',
        'salary' => '$10,000'
      ],
      [
        'id' => 3,
        'title' => 'Teacher',
        'salary' => '$40,000'
      ]
    ];
  }

  public static function find(int $id): array
  {
    $job = Arr::first(static::all(), fn($job) => $job['id'] == $id);

    if (!$job) {
      abort(404);
    }

    return $job;
  }
  */
}
