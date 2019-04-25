<?php

namespace Tests;

use DB;
use Jenssegers\Mongodb\Schema\Blueprint;

trait RefreshCollections
{
    public function setUp(): void
    {
        parent::setUp();

        if ($this->hasDependencies()) {
           return;
        }

       $this->dropAllCollections();
    }

    protected function dropAllCollections()
    {
        $mongo = DB::connection('mongodb');

        foreach ($mongo->listCollections() as $collection) {
            if (starts_with($name = (string) $collection->getName(), 'system')) {
                continue;
            }

            (new Blueprint($mongo, $name))->drop();
        }
    }
}
