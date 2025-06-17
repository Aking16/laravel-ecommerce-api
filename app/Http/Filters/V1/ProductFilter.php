<?php

namespace App\Http\Filters\V1;

class ProductFilter extends QueryFilter
{
  protected $sortable = [
    'name',
    'description',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'created_at',
    'updated_at'
  ];

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

  public function meta_title($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('meta_title', 'like', $likeStr);
  }

  public function meta_description($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('meta_description', 'like', $likeStr);
  }

  public function meta_keywords($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('meta_keywords', 'like', $likeStr);
  }

  public function created_at($value)
  {
    $dates = explode(',', $value);

    if (count($dates) > 1) {
      return $this->builder->whereBetween('created_at', $dates);
    }

    return $this->builder->whereDate('created_at', $value);
  }

  public function updated_at($value)
  {
    $dates = explode(',', $value);

    if (count($dates) > 1) {
      return $this->builder->whereBetween('updated_at', $dates);
    }

    return $this->builder->whereDate('updated_at', $value);
  }
}