<?php
// System functions
function to_object($array){
    return json_decode(json_encode($array));
}