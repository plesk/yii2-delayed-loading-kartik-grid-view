<?php
// Copyright 1999-2017. Plesk International GmbH. All rights reserved.

namespace plesk\delayedloadingkartikgridview;

use Yii;
use kartik\grid\GridView as KartikGridView;
use yii\data\BaseDataProvider;
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

            $this->view->registerJs(
                '$("document").ready(function(){
                    $.pjax.reload({container:"#' . $this->pjaxSettings['options']['id'] . '"});
                });'
            );
        }
    }
}