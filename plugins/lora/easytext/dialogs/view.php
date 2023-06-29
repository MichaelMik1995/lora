<?php
    require_once('../../../../core/model/easyText.php');
    $easyText = $this->injector["Easytext"];
    
    $txt = $easyText->translateText($_POST['text'], "50%");
    echo "<script>alert('".$_GET['text']."')</script>";
?>

<div class="easyText-Dialog_inner">
    <div id="view" class="es_block">
        
    </div>
</div>