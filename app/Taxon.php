<?php

namespace App;

class Taxon extends \Vanilo\Category\Models\Taxon
{
    public function products()
    {
        return $this->morphedByMany(
            Product::class, 'model', 'model_taxons', 'taxon_id', 'model_id'
        );
    }
}
