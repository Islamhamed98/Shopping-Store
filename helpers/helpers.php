<?php 

/**
 *  function to display errors 
 *  1 @parameter array of errors 
 */
function display_errors($errors) { 
    $display = '<ul class="bg-danger" >';
    foreach($errors as $error) { 
        $display.='<li class="text-danger">' . $error . '</li>';
    }
    $display.='</ul>';
    return $display;
}

function money($number) { 
    return '$' . number_format($number,2);
}

