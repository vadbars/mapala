<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use common\models\BlockChain;
use common\models\Art;

/* @var $this \yii\web\View */
/* @var $content string 
   ['label' => Yii::t('frontend', 'About'), 'url' => ['/page/view', 'slug'=>'about']],
         
 *  */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<?php
$this->registerMetaTag([
'name' => 'p:domain_verify',
'content' => '2a77368c453493113d92d6d451b0bcd1'
]); ?>

<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => "<img src=https://s13.postimg.org/ror54hqyv/logo_small.png>" . Yii::$app->name ,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
        'innerContainerOptions' => ['class'=>'container-fluid container-navbar'],
    ]); ?>
           <?php echo '<span class="logo_text">[ Everyone Can Travel ] </span>' . '<span class="span_amount">' . Yii::t("frontend","Articles") . ": " . Art::get_article_amount() . '</span>';?>
    
    
    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('frontend', 'Base'),
                'items'=>[
                     [
                        'label' => Yii::t('frontend', 'Watch'), 'url' => ['/site/index'],
                        'url' => ['/site/index']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Add Post'),
                        'url' => ['/site/add']
                    ],
                ]],
            ['label' => Yii::t('frontend', 'My blog'), 'url' => ['/site/show_single_blog'], ['visible'=>!Yii::$app->user->isGuest]],
            ['label' => Yii::t('frontend', 'ICO'), 'url' => ['/site/ico']],
           
            
            ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
            ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible'=>Yii::$app->user->isGuest],
            [
                'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                'visible'=>!Yii::$app->user->isGuest,
                'items'=>[
                     [
                        'label' => Yii::t('frontend', 'Key STEEM'),
                        'url' => ['/user/keys/index']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Settings'),
                        'url' => ['/user/default/index']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Logout'),
                        'url' => ['/user/sign-in/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ],
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function ($code) {
                    return [
                        'label' => Yii::$app->params['availableLocales'][$code],
                        'url' => ['/site/set-locale', 'locale'=>$code],
                        'active' => Yii::$app->language === $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ]
        ]
    ]); ?>
    <?php NavBar::end(); ?>
 
    
 <?php echo $content ?>

</div>


<?php $this->endContent() ?>

