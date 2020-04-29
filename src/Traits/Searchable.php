<?php

namespace Aposoftworks\LaravelUtilities\Traits;

//General
use Illuminate\Support\Facades\Request;

trait Searchable {
    public function scopeSearch ($query, $search = null) {
        $search = is_null($search)? Request::input("search"):$search;

        if ($this->searchableFields && $search) {
            $fields = $this->searchableFields;

            $query->where(function ($query) use ($fields, $search) {
                //Search for the fields in the request
                for ($i=0; $i < count($fields); $i++) {
                    //Check if the user wants to filter it
                    $query->orWhere($fields[$i], "LIKE", "%".$search."%");
                }
            });
        }
    }
}
