<?php

namespace App\Http\Filters\V1;

class ProductFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'name',
    'description',
    'metaTitle' => 'meta_title',
    'metaDescription' => 'meta_description',
    'metaKeywords' => 'meta_keywords',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  public function include($value)
  {
    $relationships = array_map('trim', explode(',', $value));

    $allowed = ['galleries', 'category'];
    $validRelationships = array_filter($relationships, fn($rel) => in_array($rel, $allowed));

    return $this->builder->with($validRelationships);
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

  public function category($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('categories_id', 'like', $likeStr);
  }

  public function metaTitle($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('meta_title', 'like', $likeStr);
  }

  public function metaDescription($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('meta_description', 'like', $likeStr);
  }

  public function metaKeywords($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('meta_keywords', 'like', $likeStr);
  }

  public function createdAt($value)
  {
    $dates = explode(',', $value);

    if (count($dates) > 1) {
      return $this->builder->whereBetween('created_at', $dates);
    }

    return $this->builder->whereDate('created_at', $value);
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
