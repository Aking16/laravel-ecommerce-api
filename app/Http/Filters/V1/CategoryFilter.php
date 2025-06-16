<?php

namespace App\Http\Filters\V1;

class CategoryFilter extends QueryFilter
{
  protected $sortable = [
    'name',
    'description',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  public function createdAt($value)
  {
    $dates = explode(',', $value);

    if (count($dates) > 1) {
      return $this->builder->whereBetween('created_at', $dates);
    }

    return $this->builder->whereDate('created_at', $value);
  }

  public function include($value)
  {
    return $this->builder->with($value);
  }

  public function name($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('name', 'like', $likeStr);
  }

  public function description($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('description', 'like', $likeStr);
  }

  public function updatedAt($value)
  {
    $dates = explode(',', $value);

    if (count($dates) > 1) {
      return $this->builder->whereBetween('updated_at', $dates);
    }

    return $this->builder->whereDate('updated_at', $value);
  }
}