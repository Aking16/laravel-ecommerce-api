<?php

namespace App\Http\Filters\V1;

use App\Models\Product;

class ProductFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'name',
    'description',
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

  public function subCategory($value)
  {
    return $this->builder->where('sub_category_id', $value);
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
