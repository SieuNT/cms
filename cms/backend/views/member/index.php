<?php

use yii\helpers\Html;
use vcms\admin\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box member-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box-header">
        <h3 class="box-title">
           &nbsp;
        </h3>
        <div class="box-tools">
            <?= Html::a(Yii::t('app', 'Create') . ' <i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-block btn-success btn-flat']) ?>
        </div>
    </div>
    <div class="box-body no-padding">
        <?php Pjax::begin(); ?>                    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        'id',
            'full_name',
            'email:email',
            'auth_key',
            'password_hash',
            // 'password_reset_token',
            // 'avatar',
            // 'address',
            // 'phone_number',
            // 'about_us',
            // 'status',
            // 'created_at',
            // 'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
            ]); ?>
                <?php Pjax::end(); ?>    </div>
</div>
