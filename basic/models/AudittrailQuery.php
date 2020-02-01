<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AuditTrail]].
 *
 * @see AuditTrail
 */
class AuditTrailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AuditTrail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AuditTrail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
