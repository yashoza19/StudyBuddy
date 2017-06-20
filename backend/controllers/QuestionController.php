<?php

namespace backend\controllers;

use Yii;
use app\models\Questions;
use app\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * QuestionController implements the CRUD actions for Questions model.
 */
class QuestionController extends Controller
{
    /**
     * @inheritdoc
     */

    public $file;

    //public $filer;

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
     * Lists all Questions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Questions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Questions();
        if ($model->load(Yii::$app->request->post())) {


            $imageName="ques"+time();

            if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
            {
                Yii::$app->response->format='json';
                return ActiveForm::validate($model);
            }
            $model->file=UploadedFile::getInstance($model, 'file');
            //$model->filer=UploadedFile::getInstance($model, 'filer');
           //print_r($_FILES);die;
            
            //if($model->validate()){
            
            $model->file->saveAs('uploads/'.$imageName.'.'.$model->file->extension );
            //$model->filer->saveAs('uploads/'.$imageName.'.'.$model->filer->extension );
            $model->question_image='uploads/'.$imageName.'.'.$model->file->extension;
            $model->answer_image='uploads/'.$imageName.'.'.$model->file->extension;
        //}
            



            /*$model->file1=UploadedFile::getInstance($model, 'file1');
            $model->file1->saveAs('uploads/'.$imageName.'.'.$model->extension );

            $model->answer_image='uploads/'.$answerName.'.'.$model->extension;*/

            $model->save(false);
            //rename & DB update query.
            return $this->redirect(['view', 'id' => $model->question_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $postValue=Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->question_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
