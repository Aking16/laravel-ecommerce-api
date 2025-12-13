<?php

namespace App\Http\Filters\V1;

class VariantsFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'name',
    'color',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  public function include($value)
  {
    $relationships = array_map('trim', explode(',', $value));

    $allowed = ['variant_categories'];
    $validRelationships = array_filter($relationships, fn($rel) => in_array($rel, $allowed));

    return $this->builder->with($validRelationships);
  }

  public function name($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('name', 'like', $likeStr);
  }

  public function color($value)
  {
    $likeStr = str_replace('*', '%', $value);
    return $this->builder->where('name', 'like', $likeStr);
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