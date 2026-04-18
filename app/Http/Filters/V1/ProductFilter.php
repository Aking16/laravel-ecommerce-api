<?php

namespace App\Http\Filters\V1;

use App\Models\Product;

class ProductFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'name',
    'description',
    'price',
    'subCategory',
    "sub_category_id",
    'metaTitle' => 'meta_title',
    'metaDescription' => 'meta_description',
    'metaKeywords' => 'meta_keywords',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  protected $allowedIncludes = Product::ALLOWED_INCLUDES;

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

  public function price($value)
  {

    // Range filter: price=100,500
    if (str_contains($value, ',')) {
      [$min, $max] = explode(',', $value);

      if ($min === 'all' && $max === 'all') return $this->builder;

      return $this->builder->whereHas('skus', function ($q) use ($min, $max) {
        if ($min !== '') {
          $q->where('price', '>=', $min);
        }

        if ($max !== '') {
          $q->where('price', '<=', $max);
        }
      });
    }

    // Operator filter: gt100, lte200 etc
    if (preg_match('/^(gt|lt|gte|lte|eq|e)(\d+(\.\d+)?)/i', $value, $matches)) {

      $operatorMap = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'eq' => '=',
        'e'  => '='
      ];

      $operator = $operatorMap[strtolower($matches[1])];
      $amount = $matches[2];

      return $this->builder->whereHas('skus', function ($q) use ($operator, $amount) {
        $q->where('price', $operator, $amount);
      });
    }

    return $this->builder;
  }


  public function subCategory($value)
  {
    // If the frontend sends "0" or ["0"], select all → no filtering
    if ($value == 0 || $value === "0" || (is_array($value) && in_array("0", $value))) {
      return $this->builder;
    }

    // Convert "2,3,5" → ["2", "3", "5"]
    $ids = is_array($value) ? $value : explode(',', $value);

    return $this->builder->whereIn('sub_category_id', $ids);
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
