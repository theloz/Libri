<?php

namespace app\assets;
use Yii;
use \yii\helpers\ArrayHelper;

/**
 * Logger class
 *
 * @author llombardi
 */
class Logger {

    public $file;
    public $filename;
    public $fullfilename;
    public $lines;
    public $user;
    public $logdir;
    
    /**
     * Variables defined on each class istance
     */
    public function __construct($params = null) {
        
        $this->user = Yii::$app->user->identity->id;

        if(!isset($params['dir']) && $params['dir']==''){
            $this->logdir = \Yii::getAlias('@app')."/log/";
        }
        if(!isset($params['name']) && $params['name']==''){
            $this->filename = "log_".$this->user."_".date('Y_m_d').".log";
        }
        $this->fullfilename = $this->logdir.$this->filename;
    }
    public function open(){
        if(!isset($this->file)){
            $this->file = fopen($this->fullfilename, "a+");
        }
    }

    public function write($params = null){
        $separator = " - ";
        $line = "[". date('Y-m-d H:i:s')."]";
        $line .= $separator.Yii::$app->controller->id . "/" . Yii::$app->controller->action->id;
        $line .= (isset($params['message']) ? $separator.$params['message'] : '');
        $line .= isset($params['model'])    ? $separator."Modello: ".json_encode(ArrayHelper::toArray($params['model'])) : '';
        $line .= isset($params['errors'])   ? $separator."Errori: ".json_encode(ArrayHelper::toArray($params['errors'])) : '';

        fwrite($this->file, $line."\n");
    }
    
    public function close(){
        fclose($this->file);
        $this->file = null;
    }
}
