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

Form::macro('delete',function($url, $button_label='Delete',$form_parameters = array(),$button_options=array()){

    if(empty($form_parameters)){
        $form_parameters = array(
            'method'=>'DELETE',
            'class' =>'delete-form',
            'url'   =>$url
        );
    }else{
        $form_parameters['url'] = $url;
        $form_parameters['method'] = 'DELETE';
    };

    return Form::open($form_parameters)
    . Form::submit($button_label, $button_options)
    . Form::close();
});