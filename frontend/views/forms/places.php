<?php
use common\models\Countries;
use vova07\imperavi\Widget;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BlockChain;
use common\models\OurCategory;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
$this->registerJsFile('\js/form_save.js',  ['position' => yii\web\View::POS_END]); 


$this->title = Yii::t('frontend','Places'); 

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Пополнить базу'), 'url'=> ['/site/add']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-indext">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <div class ='col-lg-7'>            
                <?php //------ Begin active form and show the title
                    $form = ActiveForm::begin(['id' => 'add-form']); 
                    echo $form->field($model, 'title') ?>

                <?php //-------SHOW Categories-----------------//TODO - List PRE-data.   
                    echo $form->field($model, 'tags')->widget(Select2::classname(),[
                        'options' => ['placeholder' => 'Select a category ...'],
                        "data" => ArrayHelper::map(OurCategory::find()
                            ->Where(['model' => StringHelper::basename(get_class($model))])
                            ->all(), BlockChain::get_blockchain_from_locale(), BlockChain::get_blockchain_from_locale()),
                    //---------------------------------------------------------------------
                        ]);?> 


                <?php //Show Countries-------------------------------------------------------------
                echo $form->field($model, 'country')->widget(Select2::classname(),[
                     'options' => ['placeholder' => 'Select a state ...'],

                    "data" => ArrayHelper::map(Countries::find()->all(),'id','name'),
                    'pluginEvents' => [
                     ],//---------------------------------------------------------------------
                ]); 
                ?>

                 <?php //---------------- EDITOR------------------------------
                 echo $form->field($model, 'body')->widget(Widget::className(), [
                    'settings' => [
                        'minHeight' => 400,
                         'imageResizable' => true,
                         'imagePosition' => true,
                        'imageUpload' => yii\helpers\Url::to(['/site/image-upload']),
                        'plugins' => [
                            'fullscreen',
                            'imagemanager'
                        ]
                    ]//-------------------------------------------------
                ]);?> 


                <div class="form-group">
                       <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
                       <div class ="loader_head"  style="display: none;">Transaction...
                       <div id = 'steem_load' class = 'loader' ></div>
                       </div>    </div>
                        <div id="account_name"></div>
                     
                          <?= $this->render('map',['model'=>$model, 'form' => $form]) ?>
                          <?php ActiveForm::end(); ?>


        </div>
            
            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Title') ?>
                    </div>
                           <div class="panel-body"><?= Yii::t('frontend', 'Постарайся уложиться в 100 символов, кратко и емко рассказав Главное') ?></div>
                </div>

                
            </div>
            


            <div class ='col-lg-5'>
                  <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Country') ?>
                    </div>
                <div class="panel-body"><?= Yii::t('frontend', 'Страна будет размещена в "голове" дерева тегов') ?></div>
                   </div>
            </div>
            




            <div class='col-lg-5'>
               <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Category') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 
                            '- <b>Природа</b> - все природные чудеса и интересности вносить сюда; <br>'
                            . '- <b>Человек</b> - люди создали что-то особенное и интересное? Пиши сюда; <br>'
                           ) ?></div>
                </div>
            </div>
            


            <div class ='col-lg-5'>
                <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Инструкция к редактору:') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Для установки картинки, вставьте в редактор прямую ссылку на нее.<br>'
                         . 'Используется базовый синтаксис html, без поддержки MarkDown. <br>'
                        );?>
                    </div>
                </div>
            </div>





            <div class ='col-lg-5'>
                 <div class="panel panel-success">
                    <div class="panel-heading">   
                        <?= Yii::t('frontend', 'Coordinates') ?>
                    </div>
                    <div class="panel-body"><?= Yii::t('frontend', 'Очень тяжело найти особенное без без точных координат. Помоги другим путешественникам, укажи координаты точно.') ?></div>
                </div>
            </div>
            
    </div>
        
</div>
    
<?php
        yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHead','class'=>'text-center'],
            'header' => '<h2>' . Yii::t('frontend', 'Ключ Golos') . '</h2>',
            'id' => 'modalKey',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'options'=>['style'=>'min-width:400px']
        ]);


        echo $this->context->renderPartial('@frontend/modules/user/views/keys/keysForm');
        yii\bootstrap\Modal::end();

        ?>
    
        
    <script>
        
    $('#add-form').on('beforeSubmit', function () {
          $('.loader_head').css('display', 'inline');
    });
    var acc = '<?= BlockChain::get_blockchain_from_locale()?>' + 'ac';
       acc = getCookie(acc);
       if (acc){
          $('#account_name').text(acc);
       } else {
         $('<a id="key_modal_ask"><?php echo Yii::t('frontend', 'укажите приватный ключ от аккаунта GOLOS') ?></a>').appendTo('#account_name');
         $(":submit").attr("disabled", true);
       } 
       
       $("#key_modal_ask").click(function() {
          $('#modalKey').modal('show');
       });
 
   </script>
     
 