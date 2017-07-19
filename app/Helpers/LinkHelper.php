<?php

function set_active($route)
{
    return Request::url() == $route ? 'is-active' :  ''; 
}