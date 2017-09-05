<?php

function truncate($value, $width = '200px')
{
	return '<span class="d-inline-block text-truncate" style="max-width: '.$width.'">'.$value.'</span>';
}