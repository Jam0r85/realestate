<?php

function parentModel($value = null)
{
	if (!$value) {
		return null;
	}

	return studly_case(str_singular($value));
}