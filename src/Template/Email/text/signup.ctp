<?= __('Hi {0},', $user->username)?>
<?= "\n\n" ?>
    <?php echo __('You or someone registered at our site {0}', $this->Url->build('/', true))."\n";?>
<?= "\n" ?>
    <?php echo __('Your login details are:')."\n" ?>
    <?php echo __('Email');?>: <?php echo $user->email."\n" ?>
    <?php echo __('Username');?>: <?php echo $user->username."\n" ?>
    <?php if(isset($user->password)&&!preg_match("/\$[\w\W]{1,10}\$[\w\W]{1,10}\$.*$/i", $user->password)):?>
    <?php echo __('Password');?>: <?php echo $user->password."\n" ?>
    <?php endif; ?>
<?= "\n\n" ?>
    <?php echo __('If you think that this email is spam just skip this message')."\n" ?>
    <?php if(!empty($user->activation_code)): ?>
        <?= "\n\n" ?>
        <?php
            $activationUrl = $this->Url->build(['controller' => 'Users', 'action' => 'activate', $user->activation_code]);
            echo __('To continue use your account, you need to activate it by this link {0}.', $activationUrl) ."\n";
        ?>
        <?= "\n\n" ?>
    <?php endif; ?>
    <?php echo __('Also we strongly recommend you change your password after your first login.')."\n"?>
<?= "\n\n" ?>
    <?php echo __('Thank You');?>
    <?= $this->Url->build('/', true) ?>
