Plesk extension for Yii2 framework to load kartik GridView via pjax during opening the page
============================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

- Add the following lines to your `composer.json` file:

    ```js
    "repositories": [
        {
            "type": "vcs",
            "url":  "ssh://git@git.plesk.ru:7999/id/yii2-delayed-loading-kartik-grid-view.git"
        }
    ]
    ```

- Run `composer require "plesk/yii2-delayed-loading-kartik-grid-view:^1.0.0"`

API
------------

```php
use plesk\delayedloadingkartikgridview\GridView;

// For ActiveDataProvider/SqlDataProvider no extracode needed.
// For ArrayDataProvider:
if (Yii::$app->request->isAjax) {
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
} else {
    $dataProvider = new ArrayDataProvider([
        ...
        'allModels' => [],
        ...
    ]);
}
```

Exceptions

- plesk\delayedloadingkartikgridview\exceptions\Exception

    All exceptions thrown by the extension, extend this exception.
