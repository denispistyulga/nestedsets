<?php

namespace app\controllers\menu;

use app\models\menu\Menu;
use app\models\menu\SearchMenu;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'view-ajax', 'move', 'tree', 'create', 'update', 'delete'],
                            'roles' => ['admin'],
                        ]
                        ]
                ]
            ]
        );
    }

    /**
     * Lists all Menu models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchMenu();
        $dataProvider = $searchModel->search($this->request->queryParams);

        //Логи
        User::CreateSomeErrorLog('Зашёл на главную страницу');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //Логи
        User::CreateSomeErrorLog('Зашёл в просмотр страницы '.$id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewAjax($id)
    {
        //Логи
        User::CreateSomeErrorLog('Зашёл в просмотр страницы ViewAjax '.$id);

        return $this->renderAjax('_form', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */


//Перемещение элементов меню
    public function actionMove($item, $action, $second)
    {
        $item_model=Menu::findOne($item);
        $second_model=Menu::findOne($second);

        switch ($action):
//Вставка элемента после другого элемента
            case 'after':
                $item_model->insertAfter($second_model);
                break;

//Вставка элемента перед другим элементом
            case 'before':
                $item_model->insertBefore($second_model);
                break;

//Добавление в качестве последнего дочернего элемента другого элемента
            case 'over':
                $item_model->appendTo($second_model);
                break;

            endswitch;

        //Логи
        User::CreateSomeErrorLog('Зашёл по ссылке Move '.$item.' '. $action.' '. $second);

            return 'Сохранено';
    }

//Покажем графически структуру таблицы меню
    public function actionTree($id=50)
    {
        $status='';
        $model_result=NULL;
        try {
            $model = Menu::findOne($id);
            if (!empty($model)) {
               $model_result=$model->tree();
            }
            else {
                $status='Запись не найдена';
            }
        } catch (\Exception $e) {
            $status=$e->getMessage();
        }


        $searchModel = new SearchMenu();
        $dataProvider = $searchModel->search($this->request->queryParams);

        //Логи
        User::CreateSomeErrorLog('Зашёл по ссылке Tree '.$id);

        return $this->render('tree/index', [
            'data'=>$model_result,
            'status'=>$status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
            ]);
    }

    public function actionCreate()
    {
        $model = new Menu();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {

                if (empty($model->sub_menu)) {
                    $model->makeRoot();
                }
                else {
                    $parent=Menu::find()
                        ->andWhere(['id'=>$model->sub_menu])
                        ->one();
                    $model->prependTo($parent);
                }
                //Логи
                User::CreateSomeErrorLog('Зашёл по ссылке Create '.$model->id);

//                if ($model->save()) {
                    return $this->redirect(['tree', 'id' => $model->id]);
//                }

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {

                if (empty($model->sub_menu)) {
                    $model->makeRoot();
                }
                else {
                    $parent=Menu::find()->andWhere(['id'=>$model->sub_menu])->one();
                    $model->prependTo($parent);
                }

//                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
//                }

            }
        }

        //Логи
        User::CreateSomeErrorLog('Зашёл по ссылке Update '.$model->id);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //Логи
        User::CreateSomeErrorLog('Удалил запись '.$id);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
