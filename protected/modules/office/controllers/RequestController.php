<?php

namespace application\modules\office\controllers;

use application\modules\office\models\Request;
use CHttpException;
use Controller;
use Yii;

/**
 * Контроллер заявок для авторизованного пользователя
 */
class RequestController extends Controller
{
    /**
     * @var string домашний URL
     */
    public $home_url = '/requests';

    /**
     * Список заявок
     */
    public function actionIndex()
    {
        $model = new Request();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionAccept($id)
    {
        $model = $this->loadModel($id);
        $model->status = "В работе";
        $model->id_user = Yii::app()->user->id;

        if ($model->validate() && $model->save()) {
            $this->redirect($this->home_url);
        }
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionReject($id)
    {
        $model = $this->loadModel($id);
        $model->status = "Отклонена";

        if ($model->validate() && $model->save()) {
            $this->redirect($this->home_url);
        }
    }

    /**
     * @todo Реализовать завершение заявки
     * @param $id
     */
    public function actionFinish($id)
    {
    }

    /**
     * @param integer $id
     * @return Request
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Request::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Запрашиваемая страница не существует');
        }
        return $model;
    }
}