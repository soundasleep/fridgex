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

/**
 * Returns a relative date.
 */
function my_format_date_simple($d) {
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

	return date("Y-m-d", strtotime($d));
}

/**
 * Returns a relative date, wrapped with a &lt;span&gt; to also describe
 * the precise date according to RFC 2822.
 */
function my_format_date($d) {
	$formatted = my_format_date_simple($d);
	if (!$d) {
		return $formatted;
	}

	return '<span class="date" title="' . htmlspecialchars(date('r', strtotime($d))) . '">' . $formatted . '</span>';
}

function get_surcharge_for_product($product) {
	$price = $product->getPrice();

	$surcharge = sfConfig::get("app_surcharge", 0);
	$surcharge_units = sfConfig::get("app_surcharge_units", 100);

	// extra surcharge?
	$extra = 0;
	if ($product->getExtraSurcharge()) {
		$extra = $product->getExtraSurcharge() / 100; 		// convert into %
	}

	if (!$surcharge) return 0;
	if (strpos($surcharge, "%") !== false) {
		// a %-based surcharge
		$surcharge = (str_replace("%", "", $surcharge)) * 0.01;		// to %
		$surcharge += $extra;	// add any extra surcharge
		return round(($price * $surcharge * $surcharge_units)) / $surcharge_units;	// to the units
	} else {
		// a fixed-price surcharge
		return (round($surcharge * $surcharge_units) / $surcharge_units) * (1 + $extra);			// to the units
	}
}

function apply_surcharge_product($product) {
	return $product->getPrice() + get_surcharge_for_product($product);
}

function yes_icon() {
	return '<span class="yes">Y</span>';
}
function no_icon() {
	return '<span class="no"></span>';
}
