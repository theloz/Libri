<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audit_trail".
 *
 * @property int $id
 * @property string|null $table_name
 * @property string|null $column_name
 * @property int|null $row_name
 * @property string|null $change_dttm
 * @property int|null $change_by
 * @property string|null $old_value
 * @property string|null $new_value
 */
class AuditTrail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_trail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['row_name'], 'default', 'value' => null],
            [['row_name', 'change_by'], 'integer'],
            [['change_dttm'], 'safe'],
            [['table_name', 'column_name'], 'string', 'max' => 50],
            [['old_value', 'new_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'column_name' => Yii::t('app', 'Column Name'),
            'row_name' => Yii::t('app', 'Row Name'),
            'change_dttm' => Yii::t('app', 'Change Dttm'),
            'change_by' => Yii::t('app', 'Change By'),
            'old_value' => Yii::t('app', 'Old Value'),
            'new_value' => Yii::t('app', 'New Value'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AuditTrailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuditTrailQuery(get_called_class());
    }
}
