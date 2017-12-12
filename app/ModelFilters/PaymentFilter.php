<?php 

namespace App\ModelFilters;

class PaymentFilter extends BaseFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * Filter results by method.
     * 
     * @param  string  $slug
     * @return 
     */
    public function method($slug)
    {
    	return $this->related('method', 'slug', '=', $slug);
    }

    /**
     * Filter results by parent.
     * 
     * @param  string $parent
     * @return 
     */
    public function parent($parent)
    {
        return $this->where('parent_type', $parent);
    }
}
