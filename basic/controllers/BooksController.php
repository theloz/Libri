<?php

namespace app\controllers;

use Yii;
use app\models\Libri;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadCatalogue;
use yii\web\UploadedFile;


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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $dataProvider = new ActiveDataProvider([
            'query' => Libri::find(),
        ]);

        return $this->render('index', [
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
                echo "<pre>";
                if (($h = fopen('/var/www/html/public/'.$model->csvfile->name, "r")) !== FALSE) {
                    // Convert each line into the local $data variable
                    $i = 0;
                    while (($data = fgetcsv($h, 2000, $sep)) !== FALSE) {
                        //skip first line
                        if($i<$firstlines){
                            $i++;
                            continue;
                        }
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
                            if(!$book->save()){
                                print_r($book->getErrors());
                                exit;
                            }
                            $i++;
                        }
                    }

                    // Close the file
                    fclose($h);
                }
                echo "</pre>";
                return;
            }
        }
        return $this->render('upload', ['model' => $model]);
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
}
