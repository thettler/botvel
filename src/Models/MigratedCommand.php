<?php

namespace Thettler\Botvel\Models;

use Illuminate\Database\Eloquent\Model;
use Thettler\Botvel\Collections\MigratedCommandsCollection;

class MigratedCommand extends Model
{
    protected $guarded = [];


    public function newCollection(array $models = []): MigratedCommandsCollection
    {
        return new MigratedCommandsCollection($models);
    }
}
