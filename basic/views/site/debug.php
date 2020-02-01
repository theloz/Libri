<pre style="height: auto;
    max-height: 600px;
    overflow: auto;
    background-color: #eeeeee;
    word-break: normal !important;
    word-wrap: normal !important;
    white-space: pre !important;"><code>
<?php
$fname="/var/www/html/basic/runtime/logs/app.log";
if(file_exists($fname)){
    echo file_get_contents("/var/www/html/basic/runtime/logs/app.log");
}
else{
    echo Yii::t('app',"File not found");
}
?>
</code></pre>