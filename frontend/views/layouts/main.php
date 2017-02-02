<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
/* @var $content string */
use cybercog\yii\googleanalytics\widgets\GATracking;
echo GATracking::widget([
    'trackingId' => 'UA-89551963-1',
]) ;


$this->beginContent('@frontend/views/layouts/base.php')
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>


<script>
    var t=<?php echo time(); ?>000;

      TimeShift.setTimezoneOffset(0);      
    
    console.log('t',t);
   if(Date) {
       try{
           Date = null;
           Date = TimeShift.Date;                      // Overwrite Date object
           //new Date().toString();
           // console.log('>>>',window.servertimestamp)
           TimeShift.setTime(t);           // Set the time to 2012-02-03
           console.log('Date Chanded toss', new Date().toString())

            //$.get( "http://144.217.94.119:8090", {"jsonrpc":"2.0","id":"25","method":"get_dynamic_global_properties","params": [""]} )
            //  .done(function( data ) {
            //    alert( "Data Loaded: " + data );
            // });
           //Сходим за нормальным временем
       } catch(exeption) {
           console.log("Couldn't override Date object.");
       }
   }
</script>

<div class="container-fluid">
        <div class ="container_for_all">
        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php if(Yii::$app->session->hasFlash('alert')):?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ])?>
        <?php endif; ?>
        <?php if(Yii::$app->session->hasFlash('success')):?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('success'), 'options'),
            ])?>
        <?php endif; ?>
        
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?php Yii::t('frontend', 'Saved') ?></h4>
            <?= Yii::$app->session->getFlash('success') ?>
            </div>
       <?php endif; ?>

   
        <?php echo $content ?>

    </div>
    </div>
<?php $this->endContent() ?>

<div class ="version">alfa 1.01 <a href="http://mapala.ru">(0-~)</a></div>

<script>
    //function for show one category by Event onclick on the Tree
    function function_a(data){
        $.ajax({
            method: "GET",
            data: {
                categories:data
            },
            url: '/ajax/category',
            success: function(view) {
                $('#article-index').html(view);
                history.pushState('', '',"/category/"+ data);

            }
        });
    }

    $( document ).ready(function() {
        $('.jstree').bind("changed.jstree", function(e, data, x){
            function_a(JSON.stringify(data.selected));
        });
    });
</script>