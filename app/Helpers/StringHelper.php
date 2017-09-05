<?php

function truncate($value, $width = '250px')
{
	return '<span class="d-inline-block text-truncate" style="max-width: '.$width.'">'.$value.'</span>';
}