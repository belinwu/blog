<?php

op::before('/admin*', function () {
	$root = op::session('root');
	if (!isset($root)) {
		op::error(404);
	} else {
		return true;
	}
});
