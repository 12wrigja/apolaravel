<?php

// app/macros.php

Form::macro('dropdown', function($dropdownVariable, $dropdownValues)
{
    $form = "<div class=\"field\"><select class='ui selection dropdown' name='$dropdownVariable'>\n";
    foreach($dropdownValues as $key=>$value){
    	$form = $form."<option value=\"$key\">$value</option>";
    }
    $form = $form."</select></div>\n";
    return $form;
});

Html::macro('semToText',function($number){
	$year = $number >> 1;
	$season = (($number & 1) == 1 ? 'Fall':'Spring');
	return $season.' '.$year;
});