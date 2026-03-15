<?php

namespace App\Http\Filters\V1;

class CartsFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  public function include($value)
  {
    $relationships = array_map('trim', explode(',', $value));

    $allowed = [
      'items',
      'items.attribute'
    ];

    $validRelationships = array_filter($relationships, fn($rel) => in_array($rel, $allowed));

    return $this->builder->with($validRelationships);
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
