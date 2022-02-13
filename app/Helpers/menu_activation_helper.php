<?php
if(!function_exists('onActiveMenu')){
    function onActiveMenu($uri){
        return service('uri')->getSegment(2) == $uri ? 'active' : '';
    }
}
?>