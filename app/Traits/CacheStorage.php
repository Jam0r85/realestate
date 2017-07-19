<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheStorage
{
    /**
     * The tags to be allocated to the cache.
     *
     * @var array
     */
    protected $tags = [];

    /**
     * Creat the trait instance.
     */
    public function __construct()
    {
        // When loading the trait, we store the className should the method exist in the tags.
        if (method_exists($this, 'getClassName')) {
            if (!in_array($this->getClassName(), $this->getTags())) {
                $this->storeTag($this->getClassName());
            }
        }
    }

    /**
     * Get the current tags stored.
     *
     * @return array
     */
    private function getTags()
    {
        return $this->tags;
    }

    /**
     * Add new tags.
     *
     * @param void
     */
    private function storeTag($tags)
    {
        if (!is_array($tags)) {
            $tags = str_split($tags);
        }

        array_push($this->tags, $tags);

        return $tags;
    }

    /**
     * Format the cache name with the correct preset and current page number.
     *
     * @return string
     */
    public function cacheName()
    {
        if (method_exists($this, 'getClassName')) {
            return config('cache.prefix') . $this->getClassName();
        }
    }

    /**
     * Get the cache name for a single record.
     *
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cacheNameSingle($id)
    {
        return $this->cacheName() . '_' . $id;
    }

    /**
     * Get the cache name with pages.
     *
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function cacheNamePaged($custom_name = null)
    {
        $name = $this->cacheName();

        if ($custom_name) {
            $name .= '_' . $custom_name . '_';
        }

        return $name .= '_page_' . $this->getCurrentPage();
    }

    /**
     * Get the page number from the current request.
     *
     * @return integer
     */
    public function getCurrentPage()
    {
        return request()->has('page') ? request()->page : 1;
    }


    /**
     * Store and retreive a collection from the cache to speed up loading times.
     *
     * @param  string  		$name
     * @param  collection  	$records
     * @param  array   		$tags
     * @param  integer 		$period
     * @return collection
     */
    public function cacheStorage($records, $name = null, $tags = [], $period = 60)
    {
        if ($records instanceof LengthAwarePaginator) {
            $name = $this->cacheNamePaged($name);
        }

        $tags = $this->storeTag($tags);

        $storage = Cache::tags($tags)
            ->remember(
                $name,
                $period,
                function () use ($records) {
                    return $records;
                }
            );

        return $storage;
    }

    /**
     * Clear a collection from the cache.
     *
     * @param  string $name
     * @return void
     */
    public function clearCache($name = null, $tags = [])
    {
        $tags = $this->storeTags($tags);

        Cache::forget($this->cacheName());
        Cache::tags($this->cacheTags($tags))->flush();
    }
}
