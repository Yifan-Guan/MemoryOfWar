<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
<<<<<<< HEAD
use frontend\models\WordCloud;
=======
>>>>>>> herosearch
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
<<<<<<< HEAD

    /**
     * 显示抗战80周年词云
     * 调用 WordCloud Model 获取数据并传递给视图
     * 
     * @return mixed 渲染 wordcloud 视图
     */
    public function actionWordcloud()
    {
        $words = WordCloud::getWords();
        $pageTitle = WordCloud::getPageTitle();
        $pageDescription = WordCloud::getPageDescription();
        
        return $this->render('wordcloud', [
            'words' => $words,
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
        ]);
    }
=======
>>>>>>> herosearch
}
