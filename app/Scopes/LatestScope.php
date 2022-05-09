<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

Class LatestScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        $builder->orderBy($model::CREATED_AT, 'desc');
    }
}
