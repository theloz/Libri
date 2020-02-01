<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadCatalogue is the model behind the upload form.
 */
class UploadCatalogue extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $csvfile;
    public $separator;
    public $firstline;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['csvfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'checkExtensionByMimeType' => false,],
            [['separator'], 'string', 'max' => 2],
            [['firstline'], 'string', 'max' => 2],
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $this->csvfile->saveAs('/var/www/html/public/' . $this->csvfile->baseName . '.' . $this->csvfile->extension);
            return true;
        } else {
            return false;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'separator' => Yii::t('app','Separator'),
            'csvfile' => Yii::t('app','Csv file'),
            'firstline' => Yii::t('app','Skip these lines'),
        ];
    }
}