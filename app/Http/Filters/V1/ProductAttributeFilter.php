<?php

namespace App\Http\Filters\V1;

use App\Models\ProductAttribute;

class ProductAttributeFilter extends QueryFilter
{
  protected $sortable = [
    'id',
    'price',
    'stock',
    'sku',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at'
  ];

  protected $allowedIncludes = ProductAttribute::ALLOWED_INCLUDES;

  public function price($value)
  {
    // Match shorthand operator and numeric value
    // Checks gt, lt, gte, lte, eq, e followed by a number (with optional decimal)
    // Example: gt100, lt50.5, gte200, lte150
    if (preg_match('/^(gt|lt|gte|lte|eq|e)(\d+(\.\d+)?)/i', $value, $matches)) {
      $operatorMap = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'eq' => '=',
        'e' => '=',
      ];

      $operatorKey = strtolower($matches[1]);
      $amount = $matches[2];

      if (isset($operatorMap[$operatorKey])) {
        return $this->builder->where('price', $operatorMap[$operatorKey], $amount);
      }
    }

    return $this->builder;
  }

  public function stock($value)
  {
    if (preg_match('/^(gt|lt|gte|lte|eq|e)(\d+(\.\d+)?)/i', $value, $matches)) {
      $operatorMap = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'eq' => '=',
        'e' => '=',
      ];

      $operatorKey = strtolower($matches[1]);
      $amount = $matches[2];

      if (isset($operatorMap[$operatorKey])) {
        return $this->builder->where('stock', $operatorMap[$operatorKey], $amount);
      }
    }

    return $this->builder;
  }

  public function discountNumber($value)
  {
    if (preg_match('/^(gt|lt|gte|lte|eq|e)(\d+(\.\d+)?)/i', $value, $matches)) {
      $operatorMap = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'eq' => '=',
        'e' => '=',
      ];

      $operatorKey = strtolower($matches[1]);
      $amount = $matches[2];

      if (isset($operatorMap[$operatorKey])) {
        return $this->builder->where('discount_number', $operatorMap[$operatorKey], $amount);
      }
    }

    return $this->builder;
  }

  public function discountPercentage($value)
  {
    if (preg_match('/^(gt|lt|gte|lte|eq|e)(\d+(\.\d+)?)/i', $value, $matches)) {
      $operatorMap = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'eq' => '=',
        'e' => '=',
      ];

      $operatorKey = strtolower($matches[1]);
      $amount = $matches[2];

      if (isset($operatorMap[$operatorKey])) {
        return $this->builder->where('discount_percentage', $operatorMap[$operatorKey], $amount);
      }
    }

    return $this->builder;
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
