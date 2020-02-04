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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
            return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
                // // Open the file for reading
                // echo "<pre>";
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
                            if($data[0]!=''){
                                $i++;
                                //check if the book exists
                                $existing = Libri::find()->where(['codice'=>$data[0]])->one();
                                if(isset($existing->id) && $existing->id!="" ) {
                                    $oldprice = $existing->prezzo_copertina;
                                    $oldavail = (string)$existing->disponibilita;
                                    $existingId = $existing->id;
                                    $update = false;
                                    if( $oldprice != $data[5] ){
                                        //save audit for price
                                        $audit = new AuditTrail();
                                        $audit->table_name = 'libri';
                                        $audit->column_name = 'prezzo_copertina';
                                        $audit->row_name = $existingId;
                                        $audit->change_dttm = new \yii\db\Expression('NOW()');
                                        $audit->change_by = Yii::$app->user->identity->id;
                                        $audit->old_value = $oldprice;
                                        $audit->new_value = $data[5];
                                        if(!$audit->save()){
                                            print_r($audit->getErrors());
                                            exit;
                                        }
                                        $update = true;
                                    }
                                    if( $oldavail != $data[10] ){
                                        //save audit for availability
                                        $audit = new AuditTrail();
                                        $audit->table_name = 'libri';
                                        $audit->column_name = 'disponibilita';
                                        $audit->row_name = $existingId;
                                        $audit->change_dttm = new \yii\db\Expression('NOW()');
                                        $audit->change_by = Yii::$app->user->identity->id;
                                        $audit->old_value = $oldavail;
                                        $audit->new_value = $data[10];
                                        if(!$audit->save()){
                                            print_r($audit->getErrors());
                                            exit;
                                        }
                                        $update = true;
                                    }
                                    if($update){
                                        //save the new data
                                        $existing->prezzo_copertina = $data[5];
                                        $existing->disponibilita = $data[10];
                                        $existing->mod_dttm = new \yii\db\Expression('NOW()');
                                        $existing->mod_id = Yii::$app->user->identity->id;
                                        $existing->save();
                                    }
                                }
                                //otherwise insert a new data
                                else{
                                    $book = new Libri();
                                    $book->codice = $data[0];
                                    $book->ean13 = $data[1];
                                    $book->titolo = $data[2];
                                    $book->autore = $data[3];
                                    $book->editore = $data[4];
                                    $book->prezzo_copertina = $data[5];
                                    $book->codice_collana = $data[6];
                                    $book->collana = $data[7];
                                    $book->argomento = $data[8];
                                    $book->linea_prodotto = $data[9];
                                    $book->disponibilita = $data[10];
                                    $book->create_dttm = new \yii\db\Expression('NOW()');
                                    $book->mod_dttm = new \yii\db\Expression('NOW()');
                                    $book->create_id = Yii::$app->user->identity->id;
                                    $book->mod_id = Yii::$app->user->identity->id;
    
                                    if(!$book->save()){
                                        print_r($book->getErrors());
                                        exit;
                                    }
                                    // echo "Riga $i salvata\n";
                                }
                            }
                        }
                    }
                    // Close the file
                    fclose($h);
                }
                // echo "</pre>";
                return $this->redirect(['index']);
                // return ;
            }
        }
        return $this->render('upload', ['model' => $model]);
    }
    public function actionBookDetails() {
        if (isset($_POST['expandRowKey'])) {
            $model = \app\models\Libri::findOne($_POST['expandRowKey']);
            return $this->renderPartial('_book-details', ['model'=>$model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
}
