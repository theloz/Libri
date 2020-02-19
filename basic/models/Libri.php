<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libri".
 *
 * @property int $id
 * @property string|null $codice
 * @property string|null $ean13
 * @property string|null $titolo
 * @property string|null $autore
 * @property string|null $editore
 * @property string|null $prezzo_copertina
 * @property float|null $prezzo_old
 * @property float|null $prezzo_diff
 * @property string|null $codice_collana
 * @property string|null $collana
 * @property string|null $argomento
 * @property string|null $linea_prodotto
 * @property int|null $disponibilita
 * @property int|null $disponibilita_old
 * @property int|null $disponibilita_diff
 * @property string|null $create_dttm
 * @property string|null $mod_dttm
 * @property int|null $create_id
 * @property int|null $mod_id
 */
class Libri extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disponibilita', 'create_id', 'mod_id', 'disponibilita_old', 'disponibilita_diff'], 'default', 'value' => null],
            [['disponibilita', 'create_id', 'mod_id', 'disponibilita_old', 'disponibilita_diff'], 'integer'],
            [['create_dttm', 'mod_dttm'], 'safe'],
            [['prezzo_old', 'prezzo_diff'], 'number'],
            [['codice', 'codice_collana'], 'string', 'max' => 15],
            [['ean13'], 'string', 'max' => 20],
            [['titolo'], 'string', 'max' => 255],
            [['autore', 'editore', 'prezzo_copertina', 'collana', 'argomento'], 'string', 'max' => 100],
            [['linea_prodotto'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codice' => Yii::t('app', 'Codice'),
            'ean13' => Yii::t('app', 'Ean13'),
            'titolo' => Yii::t('app', 'Titolo'),
            'autore' => Yii::t('app', 'Autore'),
            'editore' => Yii::t('app', 'Editore'),
            'prezzo_copertina' => Yii::t('app', 'Prezzo Copertina'),
            'codice_collana' => Yii::t('app', 'Codice Collana'),
            'collana' => Yii::t('app', 'Collana'),
            'argomento' => Yii::t('app', 'Argomento'),
            'linea_prodotto' => Yii::t('app', 'Linea Prodotto'),
            'disponibilita' => Yii::t('app', 'Disponibilita'),
            'create_dttm' => Yii::t('app', 'Create Dttm'),
            'mod_dttm' => Yii::t('app', 'Mod Dttm'),
            'create_id' => Yii::t('app', 'Create ID'),
            'mod_id' => Yii::t('app', 'Mod ID'),
            'prezzo_old' => Yii::t('app', 'Prezzo Old'),
            'prezzo_diff' => Yii::t('app', 'Prezzo Diff'),
            'disponibilita_old' => Yii::t('app', 'Disponibilita Old'),
            'disponibilita_diff' => Yii::t('app', 'Disponibilita Diff'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LibriQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LibriQuery(get_called_class());
    }
    public function getPricechanges(){
        return $this->hasMany(AuditTrail::className(), ['row_name' => 'id'])->where(['table_name'=>'libri','column_name'=>'prezzo_copertina'])->orderBy('change_dttm DESC');
    }
    public function getAvailabilitychanges(){
        return $this->hasMany(AuditTrail::className(), ['row_name' => 'id'])->where(['table_name'=>'libri','column_name'=>'disponibilita'])->orderBy('change_dttm DESC');
    }
    public function getModifyUser(){
        return $this->hasOne(User::className(),['id' => 'mod_id']);
        //return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    public function getCreateUser(){
        return $this->hasOne(User::className(),['id' => 'mod_id']);
    }
}
