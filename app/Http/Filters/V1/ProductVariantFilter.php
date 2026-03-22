<?php

namespace App\Http\Filters\V1;

use App\Models\ProductVariant;

class ProductVariantFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'productId' => 'product_id',
    'name',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  protected $allowedIncludes = ProductVariant::ALLOWED_INCLUDES;

  public function name($value)
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
