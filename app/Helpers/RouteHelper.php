<?php

if (! function_exists('show_route')) {
    function show_route($model, $subview = null, $resource = null)
    {
        $resource = $resource ?? plural_from_model($model);

        if ($subview) {
            return route("{$resource}.show", [$model, $subview]);
        }

        return route("{$resource}.show", $model);
    }
}

if (! function_exists('edit_route')) {
    function edit_route($model, $resource = null)
    {
        $resource = $resource ?? plural_from_model($model);

        return route("{$resource}.edit", $model);
    }
}