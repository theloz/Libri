<?php

namespace app\controllers;

use Yii;
use app\models\Libri;
use app\models\AuditTrail;
use app\models\search\LibriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadCatalogue;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\assets\Logger;

/**
 * BooksController implements the CRUD actions for Libri model.
 */
class BooksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','upload'],
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Libri models.
     * @return mixed
     */
    public function actionIndex()
    {
        // echo "<pre>".print_r(Yii::$app->request->queryParams,true)."</pre>";exit;
        $searchModel = new LibriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libri model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $priceDataProvider = new \yii\data\ActiveDataProvider([
            'sort' => false,
            'query' => \app\models\AuditTrail::find()->where([
                'table_name'    => 'libri',
                'column_name'   => 'prezzo_copertina',
                'row_name'      => $model->id
            ])->orderBy('change_dttm DESC'),
        ]);
        $availDataProvider = new \yii\data\ActiveDataProvider([
            'sort' => false,
            'query' => \app\models\AuditTrail::find()->where([
                'table_name'    => 'libri',
                'column_name'   => 'disponibilita',
                'row_name'      => $model->id
            ])->orderBy('change_dttm DESC'),
        ]);
        return $this->render('view', [
            'model' => $model,
            'priceDataProvider' => $priceDataProvider,
            'availDataProvider' => $availDataProvider,
        ]);
    }

    /**
     * Creates a new Libri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Libri();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->mod_dttm = new \yii\db\Expression('NOW()');
            $model->mod_id = Yii::$app->user->identity->id;
            $model->create_dttm = new \yii\db\Expression('NOW()');
            $model->create_id = Yii::$app->user->identity->id;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Libri model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";
            // echo $oldModel->prezzo_copertina;
            // echo $model->prezzo_copertina;
            // echo "</pre>";
            // exit;
            //update on audit trail
            if($oldModel->prezzo_copertina != $model->prezzo_copertina){
                $diff = number_format(((float)(str_replace(",",".",$model->prezzo_copertina)) - (float)(str_replace(",",".",$oldModel->prezzo_copertina))),2);
                $at = new \app\models\AuditTrail();
                $at->table_name = 'libri';
                $at->column_name = 'prezzo_copertina';
                $at->row_name = $model->id;
                $at->old_value = $oldModel->prezzo_copertina;
                $at->new_value = $model->prezzo_copertina;
                $at->diff_value = (string)$diff;
                $at->change_dttm = new \yii\db\Expression('NOW()');
                $at->change_by = Yii::$app->user->identity->id;
                if(!$at->save()){
                    print_r($at->getErrors());
                    exit;
                }
                $model->prezzo_old = (float)(str_replace(",",".",$oldModel->prezzo_copertina));
                $model->prezzo_diff = (float)$diff;
            }
            if($oldModel->disponibilita != $model->disponibilita){
                $diff = (int)$model->disponibilita - (int)$oldModel->disponibilita;
                $at = new \app\models\AuditTrail();
                $at->table_name = 'libri';
                $at->column_name = 'disponibilita';
                $at->row_name = $model->id;
                $at->old_value = (string)$oldModel->disponibilita;
                $at->new_value = (string)$model->disponibilita;
                $at->diff_value = (string)$diff;
                $at->change_dttm = new \yii\db\Expression('NOW()');
                $at->change_by = Yii::$app->user->identity->id;
                if(!$at->save()){
                    print_r($at->getErrors());
                    exit;
                }
                $model->disponibilita_old = (int)$oldModel->prezzo_copertina;
                $model->disponibilita_diff = (int)$diff;
            }
            $model->mod_dttm = new \yii\db\Expression('NOW()');
            $model->mod_id = Yii::$app->user->identity->id;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Libri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Libri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Libri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libri::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Creates a new Libri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpload()
    {
        $model = new UploadCatalogue();

        if (Yii::$app->request->isPost) {
            $model->csvfile = UploadedFile::getInstance($model, 'csvfile');
            if ($model->upload()) {
                // echo "<pre>".print_r($model->csvfile)."</pre>";exit;
                $sep = Yii::$app->request->post('UploadCatalogue')['separator'];
                $firstlines = (int)Yii::$app->request->post('UploadCatalogue')['firstline'];
                echo "<pre>";
                $log = new Logger();
                $log->open();
                $msg = '';
                // Open the file for reading
                if (($h = fopen('/var/www/html/public/'.$model->csvfile->name, "r")) !== FALSE) {
                    // Convert each line into the local $data variable
                    $i = 0;
                    while (($data = fgetcsv($h, 2000, $sep)) !== FALSE) {
                        //skip first n lines
                        if($i<$firstlines){
                            $i++;
                            continue;
                        }
                        else{
                            //if line's not empty
                            if(trim($data[0])!=''){
                                $i++;
                                //check if the book exists
                                $existing = Libri::find()->where(['codice'=>trim($data[0])])->one();
                                if(isset($existing->id) && $existing->id!="" ) {
                                    $oldprice = $existing->prezzo_copertina;
                                    $oldavail = (string)$existing->disponibilita;
                                    $existingId = $existing->id;
                                    $update = false;
                                    $prezzo = false;
                                    $disponibilita = false;
                                    if( $oldprice != trim($data[5]) ){
                                        //save audit for price
                                        $audit = new AuditTrail();
                                        $audit->table_name = 'libri';
                                        $audit->column_name = 'prezzo_copertina';
                                        $audit->row_name = $existingId;
                                        $audit->change_dttm = new \yii\db\Expression('NOW()');
                                        $audit->change_by = Yii::$app->user->identity->id;
                                        $audit->old_value = $oldprice;
                                        $audit->new_value = trim($data[5]);
                                        $audit->diff_value = (string)((float)(str_replace(",",".",trim($data[5]))) - (float)(str_replace(",",".",$oldprice)));
                                        if(!$audit->save()){
                                            echo print_r($audit->getErrors(),true);
                                            exit;
                                        }
                                        $existing->prezzo_old = (str_replace(",",".",trim($oldprice)));
                                        $existing->prezzo_diff = (float)(str_replace(",",".",trim($data[5]))) - (float)(str_replace(",",".",$oldprice));
                                        $update = true;
                                        $prezzo = true;
                                    }
                                    if( $oldavail != trim($data[10]) ){
                                        //save audit for availability
                                        $audit = new AuditTrail();
                                        $audit->table_name = 'libri';
                                        $audit->column_name = 'disponibilita';
                                        $audit->row_name = $existingId;
                                        $audit->change_dttm = new \yii\db\Expression('NOW()');
                                        $audit->change_by = Yii::$app->user->identity->id;
                                        $audit->old_value = $oldavail;
                                        $audit->new_value = trim($data[10]);
                                        $audit->diff_value = (string)((int)(str_replace(",",".",trim($data[10]))) - (int)(str_replace(",",".",$oldavail)));
                                        if(!$audit->save()){
                                            echo print_r($audit->getErrors(),true);
                                            exit;
                                        }
                                        $existing->disponibilita_old = (int)$oldavail;
                                        $existing->disponibilita_diff = (int)(str_replace(",",".",trim($data[10]))) - (int)(str_replace(",",".",$oldavail));
                                        $update = true;
                                        $disponibilita = true;
                                    }
                                    if($update){
                                        //save the new data
                                        $existing->prezzo_copertina = $data[5];
                                        $existing->disponibilita = $data[10];
                                        $existing->mod_dttm = new \yii\db\Expression('NOW()');
                                        $existing->mod_id = Yii::$app->user->identity->id;
                                        $existing->save();
                                        $msg = $existing->ean13." - ".$existing->titolo;
                                        if($prezzo && !$disponibilita){
                                            $msg .= " aggiornato prezzo";
                                        }
                                        else if($disponibilita && !$prezzo){
                                            $msg .= " aggiornata disponibilità";
                                        }
                                        else{
                                            $msg .= " aggiornati prezzo e disponibilità";
                                        }
                                        $log->write(['message'=>$msg]);
                                        echo $msg."\n";
                                    }
                                }
                                //otherwise insert a new data
                                else{
                                    $book = new Libri();
                                    $book->codice = trim($data[0]);
                                    $book->ean13 = trim($data[1]);
                                    $book->titolo = utf8_encode(trim($data[2]));
                                    $book->autore = utf8_encode(trim($data[3]));
                                    $book->editore = utf8_encode(trim($data[4]));
                                    $book->prezzo_copertina = trim($data[5]);
                                    $book->prezzo_old = (float)(str_replace(",",".",trim($data[5])));
                                    $book->prezzo_diff = 0;
                                    $book->codice_collana = utf8_encode(trim($data[6]));
                                    $book->collana = utf8_encode(trim($data[7]));
                                    $book->argomento = utf8_encode(trim($data[8]));
                                    $book->linea_prodotto = utf8_encode(trim($data[9]));
                                    $book->disponibilita = trim($data[10]);
                                    $book->disponibilita_old = (int)(trim($data[10]));
                                    $book->disponibilita_diff = 0;
                                    $book->create_dttm = new \yii\db\Expression('NOW()');
                                    $book->mod_dttm = new \yii\db\Expression('NOW()');
                                    $book->create_id = Yii::$app->user->identity->id;
                                    $book->mod_id = Yii::$app->user->identity->id;
    
                                    if(!$book->save()){
                                        echo print_r($book->getErrors(),true);
                                        exit;
                                    }
                                    $msg = $book->ean13." - ".$book->titolo.' inserito ['.$i.']';
                                    $log->write(['message'=>$msg]);
                                    echo $msg."\n";
                                }
                            }
                        }
                    }
                    // Close the file
                    fclose($h);
                }
                echo \yii\helpers\Html::a(Yii::t('app','Return to index'), '/books/index');
                echo "</pre>";
                $log->close();
                exit;
                return ob_get_clean();
                //return $this->redirect(['index']);
                // return ;
                // exit;
            }
        }
        return $this->render('upload', ['model' => $model]);
    }
    public function actionBookDetails() {
        if (isset($_POST['expandRowKey'])) {
            $dataProvider = new \yii\data\ActiveDataProvider([
                'sort' => false,
                'query' => \app\models\Libri::find()->where(['id'=>$_POST['expandRowKey']]),
            ]);
            $model = \app\models\Libri::findOne($_POST['expandRowKey']);
            $priceDataProvider = new \yii\data\ActiveDataProvider([
                'sort' => false,
                'query' => \app\models\AuditTrail::find()->where([
                    'table_name'    => 'libri',
                    'column_name'   => 'prezzo_copertina',
                    'row_name'      => $model->id
                ])->orderBy('change_dttm DESC'),
            ]);
            $availDataProvider = new \yii\data\ActiveDataProvider([
                'sort' => false,
                'query' => \app\models\AuditTrail::find()->where([
                    'table_name'    => 'libri',
                    'column_name'   => 'disponibilita',
                    'row_name'      => $model->id
                ])->orderBy('change_dttm DESC'),
            ]);
            return $this->renderPartial('_book-details', [
                'model'             =>$model,
                'dataProvider'      => $dataProvider,
                'priceDataProvider' => $priceDataProvider,
                'availDataProvider' => $availDataProvider,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionViewImage($ean){
        return '<img src="https://img.fastbookspa.it/images/'.$ean.'_0_575_875_0.jpg" />';
    }
}
