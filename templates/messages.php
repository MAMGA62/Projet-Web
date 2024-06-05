<?php
    if (isset($msg)){
        if ($msg !== false){
?>      
        <p class="error"><?=urldecode($msg)?></p>
<?php
        }
    }

?>