<?php

namespace app\models\search;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Libri;

/**
 * LibriSearch represents the model behind the search form of `app\models\Libri`.
 */
class LibriSearch extends Libri
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'disponibilita', 'create_id', 'mod_id'], 'integer'],
            [['codice', 'ean13', 'titolo', 'autore', 'editore', 'prezzo_copertina', 'codice_collana', 'collana', 'argomento', 'linea_prodotto', 'create_dttm', 'mod_dttm'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Libri::find();

        // add conditions that should always apply here
        $query = $this->setQuery($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->setSort([
            'enableMultiSort' => isset($params['sort']) ? false : true,
            'defaultOrder' => ['id'=>SORT_DESC, 'titolo'=>SORT_ASC],
            'attributes' => [
                'id',
                'codice',
                'ean13',
                'titolo',
                'autore',
                'editore',
                'prezzo_copertina',
                'codice_collana',
                'argomento',
                'linea_prodotto',
                'disponibilita',
                'create_dttm',
                'mod_dttm',
                'prezzo_old' =>[
                    'label'   => \Yii::t('app', 'Last price'),
                ],
                'prezzo_diff' =>[
                    'label'   => \Yii::t('app', 'Price variation'),
                ],
                'disponibilita',
                'disponibilita_old'=>[
                    'label'   => \Yii::t('app', 'Last availability'),
                ],
                'disponibilita_diff'=>[
                    'label'   => \Yii::t('app', 'Availability variation'),
                ],

            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'disponibilita' => $this->disponibilita,
            'create_dttm' => $this->create_dttm,
            'mod_dttm' => $this->mod_dttm,
            'create_id' => $this->create_id,
            'mod_id' => $this->mod_id,
        ]);

        $query->andFilterWhere(['ilike', 'codice', $this->codice])
            ->andFilterWhere(['ilike', 'ean13', $this->ean13])
            ->andFilterWhere(['ilike', 'titolo', $this->titolo])
            ->andFilterWhere(['ilike', 'autore', $this->autore])
            ->andFilterWhere(['ilike', 'editore', $this->editore])
            ->andFilterWhere(['ilike', 'prezzo_copertina', $this->prezzo_copertina])
            ->andFilterWhere(['ilike', 'codice_collana', $this->codice_collana])
            ->andFilterWhere(['ilike', 'collana', $this->collana])
            ->andFilterWhere(['ilike', 'argomento', $this->argomento])
            ->andFilterWhere(['ilike', 'linea_prodotto', $this->linea_prodotto]);

        return $dataProvider;
    }
    public function setQuery($params){
        $qPrice = 'cast( replace( libri.prezzo_copertina, \',\',\'.\' ) as float )';
        $qAvail = 'cast( libri.disponibilita as integer )';
        // $qLastPrice = (new \yii\db\Query())
        //     ->select(['cast( replace( old_value, \',\',\'.\' ) as float ) as old_value'])
        //     ->from('audit_trail')
        //     ->andWhere(['and',['table_name'=>'libri', 'column_name'=>'prezzo_copertina']])
        //     ->andWhere('row_name=libri.id')
        //     ->orderBy('change_dttm DESC')
        //     ->limit(1);
        //     ;
        // $qLastPriceDiff = (new \yii\db\Query())
        //     ->select(['cast( replace( diff_value, \',\',\'.\' ) as float ) as diff_value'])
        //     ->from('audit_trail')
        //     ->andWhere(['and',['table_name'=>'libri', 'column_name'=>'prezzo_copertina']])
        //     ->andWhere('row_name=libri.id')
        //     ->orderBy('change_dttm DESC')
        //     ->limit(1);
        //     ;
        // $qLastAvail = (new \yii\db\Query())
        //     ->select(['cast( old_value as integer ) as old_value'])
        //     ->from('audit_trail')
        //     ->andWhere(['and',['table_name'=>'libri', 'column_name'=>'disponibilita']])
        //     ->andWhere('row_name=libri.id')
        //     ->orderBy('change_dttm DESC')
        //     ->limit(1)
        //     ;
        // $qLastAvailDiff = (new \yii\db\Query())
        //     ->select(['cast( diff_value as integer ) as diff_value'])
        //     ->from('audit_trail')
        //     ->andWhere(['and',['table_name'=>'libri', 'column_name'=>'disponibilita']])
        //     ->andWhere('row_name=libri.id')
        //     ->orderBy('change_dttm DESC')
        //     ->limit(1)
        //     ;
        
        $query = Libri::find();
        
        $query->select([
            'libri.id',
            'libri.codice',
            'libri.ean13',
            'libri.titolo',
            'libri.autore',
            'libri.editore',
            'libri.codice_collana',
            'libri.collana',
            'libri.argomento',
            'libri.linea_prodotto',
            'libri.create_dttm',
            'libri.mod_dttm',
            'libri.create_id',
            'libri.mod_id',
            $qPrice.' as prezzo_copertina',
            $qAvail.' as disponibilita',
            'prezzo_old',
            'prezzo_diff',
            'disponibilita_old',
            'disponibilita_diff',
        ]);
        // echo $sql = $query->createCommand()->getRawSql();exit;
        //$data = $query->createCommand()->queryAll();
        return $query;
    }
}
