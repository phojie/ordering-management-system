<?php

declare(strict_types=1);

namespace App\Services\CustomSortsService;

use Illuminate\Database\Eloquent\Builder;

class CustomRoleSort implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->with(['roles' => function ($query) use ($direction, $property) {
            $query->orderBy($property, $direction);
        }]);
    }
}
