<?php

namespace frontend\controllers;

use yii\web\Controller;

class WordcloudController extends Controller
{
    
    public function actionIndex()
    {
        return $this->render('wordcloud');
    }
}
