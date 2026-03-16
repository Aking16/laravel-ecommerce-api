<?php

namespace App\Support;

use Illuminate\Http\Request;

class IncludeParser
{
  protected array $includes = [];

  public function __construct(Request $request, array $allowedIncludes = [])
  {
    $requested = collect(explode(',', $request->get('include', '')))
      ->map(fn($i) => trim($i))
      ->filter();

    $this->includes = $requested
      ->filter(fn($include) => in_array($include, $allowedIncludes))
      ->values()
      ->toArray();
  }

  public function get(): array
  {
    return $this->includes;
  }

  public function has(string $relation): bool
  {
    return in_array($relation, $this->includes);
  }
}
