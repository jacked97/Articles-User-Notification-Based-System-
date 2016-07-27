<?php

namespace app\controllers;

use Yii;
use app\models\database\Notices;
use app\models\Search\Notices as NoticesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoticesController implements the CRUD actions for Notices model.
 */
class NoticesController extends Controller {
    /**
     * @inheritdoc
     */

    /**
     * Lists all Notices models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NoticesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Notices();
        $trasactionCompleted = false;
        $dbTransaction = $model->getDb()->beginTransaction();
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date("Y-m-d H:i:s");
            $model->author_id = Yii::$app->user->id;
//            \app\components\DebugComponents::echoArr($_POST);
//            \app\components\DebugComponents::echoArr($model->notice_type);
            if ($model->save()) {
                foreach ($model->notice_type as $notice) {
                    $storeNewNoticeType = new \app\models\database\NoticesMtomTypes();
                    $storeNewNoticeType->notice_id = $model->id;
                    $storeNewNoticeType->notice_type_id = $notice;
                    if ($storeNewNoticeType->save())
                        $trasactionCompleted = true;
                    else
                        $trasactionCompleted = false;
                }
                if ($trasactionCompleted) {
                    $dbTransaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else
                    $dbTransaction->rollBack();
            } else
                return $this->render('create', [
                            'model' => $model,
                ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Notices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Notices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMy() {
        if (isset($_REQUEST['readId']) && is_numeric($_REQUEST['readId']))
            $this->markNoticeRead($_REQUEST['readId']);
        $userNotices = \app\models\database\NoticeReadBy::find()
                ->with('notice')
                ->where(['author_id' => Yii::$app->user->id])
                ->orderBy(['id' => SORT_DESC])
                ->all();
        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $userNotices,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'attributes' => ['id'],
            ],
        ]);

        return $this->render('myNotices', ['listDataProvider' => $provider]);
    }

    private function markNoticeRead($id) {
        \app\models\database\NoticeReadBy::updateAll(['status' => 1], ['id' => $id]);
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => \app\components\AccessRule::className(),
                ],
                'only' => ['index', 'create', 'update', 'delete', 'my'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            \app\models\User::$ADMIN
                        ],
                    ],
                    [
                        'actions' => ['my'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            \app\models\User::$ADMIN,
                            \app\models\User::$USER
                        ],
                    ],
                ],
            ],
        ];
    }

}
