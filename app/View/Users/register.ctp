<script src='https://www.google.com/recaptcha/api.js'></script>

<?php
$this->Html->meta('description', 'Inscription', array('inline' => false));
?>

<div class="col-md-offset-2 col-xs-12 col-md-12 col-lg-12 ">
    <div class="main">
        <div class="col-xs-8 col-sm-8 col-lg-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h1>Inscription</h1></div>
                </div>
                <div class="panel-body">
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
                        <legend><?php echo __('Entrez un nom de compte et un mot de passe'); ?></legend>
                        <?php
                        echo $this->Form->input('email', array('label' => '  Adresse email', 'type' => 'email'));
                        echo $this->Form->input('pass1', array('label' => 'Mot de passe', 'type' => 'password'));
                        echo $this->Form->input('pass2', array('label' => 'Confirmer le mot de passe', 'type' => 'password')); ?>
                    </fieldset>
                    <div class="g-recaptcha" data-sitekey="6Les8BATAAAAAOwKeUAOA9G2m-Jbn0Rx4o6HBkKY"></div>
                    <div class="col-md-offset-2 col-md-8"><input class="btn btn-success btn btn-success" type="submit"
                                                                 value="Register"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>