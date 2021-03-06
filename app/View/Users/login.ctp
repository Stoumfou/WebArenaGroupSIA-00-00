<?php
$this->Html->meta('description', 'Connexion', array('inline' => false));
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
                                    <h1>Connexion</h1></div>
                            </div>

                            <div class="panel-body">
                                <?php echo $this->Flash->render('auth'); ?>
                                <?php echo $this->Form->create('User', array(
                                    'class' => 'form-horizontal',
                                    'role' => 'form',
                                    'inputDefaults' => array(
                                        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
                                        'div' => array('class' => 'form-group'),
                                        'class' => array('form-control'),
                                        'label' => array('class' => 'col-xs-3 col-md-2 col-lg-2 control-label'),
                                        'between' => '<div class="col-xs-9 col-md-6 col-lg-6">',
                                        'after' => '</div>',
                                        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
                                    ))); ?>
                                <fieldset>
                                    <legend><?php echo __('Please enter your username and password'); ?></legend>
                                    <?php echo $this->Form->input('email');
                                    echo $this->Form->input('password'); ?>
                                </fieldset>
                                <div class="col-md-offset-2 col-md-8"><input class="btn btn-success" type="submit"
                                                                             value="Login"/>
                                    <a class="btn btn-default facebook" href="<?php echo BASE_PATH . 'fblogin'; ?>"> <i
                                            class="fa fa-facebook modal-icons"> Sign in with Facebook</i></a>

                                    <div><a href="forgotten">Mot de passe oublié</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>