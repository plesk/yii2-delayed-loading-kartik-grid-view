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
            "url":  "git@github.com:plesk/yii2-delayed-loading-kartik-grid-view.git"
        }
    ]
    ```

- Run `composer require "plesk/yii2-delayed-loading-kartik-grid-view:^1.0.0"`

Configuration
------------

```php
[
    'components' => [
        'pjax' => [
            'class' => 'plesk\yii2pjax\Component',
        ],
    ],
]
```

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

To handle pjax errors you should setup your handler before calling this widget.
```html
<head>
    <?php
        $this->registerJs(
            '$(document).on(\'pjax:error\', function(event, xhr, textStatus, error, options) {
                pleskMessageBox.options.title = error;
                pleskMessageBox.alert(xhr.responseText);
            });'
        );
    ?>
</head>

```

Exceptions

    - plesk\delayedloadingkartikgridview\exceptions\Exception

        All exceptions thrown by the extension, extend this exception.