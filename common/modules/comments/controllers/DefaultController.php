<?php

namespace common\modules\comments\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii2mod\comments\events\CommentEvent;
use yii2mod\comments\models\CommentModel;
use yii2mod\comments\Module;

/**
 * Class DefaultController
 * @package yii2mod\comments\controllers
 */
class DefaultController extends Controller
{
    /**
     * Event is triggered after creating a new comment.
     * Triggered with yii2mod\comments\events\CommentEvent
     */
    const EVENT_AFTER_CREATE = 'afterCreate';

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post', 'delete']
                ]
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['create'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Create comment.
     *
     * @param $entity string encrypt entity
     * @return array
     */
    public function actionCreate()
    {
        sleep(6);
        return ['status' => 'success'];
       
    }

    /**
     * Delete comment.
     *
     * @param integer $id Comment ID
     * @return string Comment text
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->deleteComment()) {
            return Yii::t('yii2mod.comments', 'Comment has been deleted.');
        } else {
            Yii::$app->response->setStatusCode(500);
            return Yii::t('yii2mod.comments', 'Comment has not been deleted. Please try again!');
        }
    }

    /**
     * Find model by ID.
     *
     * @param integer|array $id Comment ID
     * @return null|CommentModel
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        /** @var CommentModel $model */
        $commentModelClass = Yii::$app->getModule(Module::$name)->commentModelClass;
        if (($model = $commentModelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii2mod.comments', 'The requested page does not exist.'));
        }
    }

    /**
     * Get list of attributes from encrypted entity
     *
     * @param $entity string encrypted entity
     * @return array|mixed
     *
     * @throws BadRequestHttpException
     */
    protected function getCommentAttributesFromEntity($entity)
    {
        $decryptEntity = Yii::$app->getSecurity()->decryptByKey(utf8_decode($entity), Module::$name);
        if ($decryptEntity !== false) {
            return Json::decode($decryptEntity);
        }

        throw new BadRequestHttpException(Yii::t('yii2mod.comments', 'Oops, something went wrong. Please try again later.'));
    }
}