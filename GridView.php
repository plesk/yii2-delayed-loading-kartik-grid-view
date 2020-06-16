<?php
// Copyright 2017 Plesk International GmbH

namespace plesk\delayedloadingkartikgridview;

use Yii;
use yii\data\BaseDataProvider;
use yii\helpers\Json;
use kartik\grid\GridView as KartikGridView;
use plesk\delayedloadingkartikgridview\exceptions\Exception;


/**
 * For ActiveDataProvider no extracode needed.
 *
 * For ArrayDataProvider:
 * <code>
 * if (Yii::$app->request->isAjax) {
 *      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 * } else {
 *      $dataProvider = new ArrayDataProvider([
 *          ...
 *          'allModels' => [],
 *          ...
 *      ]);
 * }
 * </code>
 *
 * @see \kartik\grid\GridView
 * @see \yii\grid\GridView
 * @see http://demos.krajee.com/grid
 *
 * @package app\components\widgets
 */
class GridView extends KartikGridView
{
    public function init()
    {
        $this->pjax = true;

        parent::init();

        if (empty($this->pjaxSettings['options']['id'])) {
            if (empty($this->pjaxSettings['options'])) {
                $this->pjaxSettings['options'] = [];
            }
            $this->pjaxSettings['options']['id'] = $this->options['id'] . '-pjax';
        }

        if (!Yii::$app->request->isAjax) {
            if (!$this->dataProvider instanceof BaseDataProvider) {
                throw new Exception('The data provider must be of "' . BaseDataProvider::class . '" type.');
            }
            $this->dataProvider->setModels([]);
            $this->dataProvider->setTotalCount(0);

            // prevent the page reload in case error is occurred
            $this->view->registerJs(
                '$(document).on(\'pjax:error\', function(event, xhr, textStatus, error, options) {
                    return false;
                });'
            );
        }
    }

    public function run()
    {
        parent::run();

        $options = Json::htmlEncode(
            Yii::$app->pjax->pjaxConvertConfigWidgetToJs($this->pjaxSettings['options'])
        );
        $this->view->registerJs(
            '$.pjax.reload(' . $options . ');
            $.pjax.xhr = null;' // allow multiple pjax requests simultaneously
        );
    }
}