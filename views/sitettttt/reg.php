<h1>Регистрация</h1>

<?php
use \yii\widgets\ActiveForm;
?>
<?php
	$form = ActiveForm::begin(['class'=>'form-horizontal']);
?>

<?= $form->field($model,'login')->label('Ваш логин')->textInput(['autofocus'=>true])?>
<?= $form->field($model,'name')->label('Ваше Имя')->textInput(['autofocus'=>true])?>
<?= $form->field($model,'last_name')->label('Ваша Фамилия')->textInput(['autofocus'=>true])?>
<?= $form->field($model,'email')->label('Ваш email')->textInput(['autofocus'=>true])?>
<?= $form->field($model,'password')->label('Ваш пароль')->passwordInput()?>

<div>
	<button type="submit" class="btn btn-primary">Отправить</button>
</div>
<?php
	ActiveForm::end();
?>
	