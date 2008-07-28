<?php

function my_format_currency($a) {
	if ($a < 0) {
		return "<span class=\"negative\">$ " . number_format($a, 2) . "</span>";
	}
	if ($a == 0) {
		return " - ";
	}
	return "$ " . number_format($a, 2);
}

function my_format_date($d) {
	if (!$d) {
		return "<i>never</i>";
	}

	$secs = time() - strtotime($d);

	if ($secs < 90) {
		return number_format($secs) . " seconds ago";
	}

	if ($secs < (90 * 60)) {
		return number_format($secs / 60) . " minutes ago";
	}

	if ($secs < (48 * 60 * 60)) {
		return number_format(($secs / 60) / 60) . " hours ago";
	}

	if ($secs < (90 * 24 * 60 * 60)) {
		return number_format((($secs / 60) / 60) / 24) . " days ago";
	}

	return date_format("D-m-y", $d);

}

function get_surcharge_for($price) {
	$surcharge = sfConfig::get("app_surcharge", 0);
	$surcharge_units = sfConfig::get("app_surcharge_units", 100);

	if (!$surcharge) return 0;
	if (strpos($surcharge, "%") !== false) {
		$surcharge = (str_replace("%", "", $surcharge)) * 0.01;		// to %
		return round(($price * $surcharge * $surcharge_units)) / $surcharge_units;	// to the units
	} else {
		return round($surcharge * $surcharge_units) / $surcharge_units;			// to the units
	}
}

function apply_surcharge($price) {
	return $price + get_surcharge_for($price);
}
