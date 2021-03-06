<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 10/11/2015
 * Time: 10:49
 */
$this->Html->meta('description', 'Edition de compte', array('inline' => false));
?>
<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-xs-12 col-md-12 col-lg-12 ">
            <div class="main">
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-lg-8">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h1>Modification du mot de passe</h1></div>
                            </div>
                            <div class="panel-body">
                                <?php /*echo $this->Form->create('User');
                        echo $this->Form->input('id');
                        echo $this->Form->input('current_password');
                        echo $this->Form->input('password1');
                        echo $this->Form->input('password2');
                        echo $this->Form->end('Submit');*/ ?>
                                <?php echo $this->Form->create('User', array(
                                    'class' => 'form-horizontal',
                                    'role' => 'form',
                                    'inputDefaults' => array(
                                        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
                                        'div' => array('class' => 'form-group'),
                                        'class' => array('form-control'),
                                        'label' => array('class' => 'col-xs-3 col-md-6 col-lg-2 control-label'),
                                        'between' => '<div class="col-xs-9 col-md-6 col-lg-6">',
                                        'after' => '</div>',
                                        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
                                    ))); ?>
                                <fieldset>
                                    <legend><?php echo __('Entrez votre nouveau mot de passe'); ?></legend>
                                    <?php echo $this->Form->input('pass1', array('label' => 'Mot de passe', 'type' => 'password')); ?>
                                    <?php echo $this->Form->input('pass2', array('label' => 'Confirmer le mot de passe', 'type' => 'password')); ?>
                                </fieldset>
                                <div class="col-md-offset-2 col-md-6 col-lg-4"><input class="btn btn-success"
                                                                                      type="submit"
                                                                                      value="Edit"/>
                                </div>
                                <?php echo $this->Html->link('Suppression du compte',
                                    array('controller' => 'Arenas', 'action' => 'deleteFighter'), array(
                                        'class' => 'col-md-offset-2 col-md-6 col-lg-4 btn btn-danger')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>