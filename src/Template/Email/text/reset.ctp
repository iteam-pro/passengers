<?= __('Hi {0},', $user->username)?>
<?= "\n\n" ?>
    <?php echo __('You or someone reset password our site {0}', $this->Url->build('/', true))."\n";?>
<?= "\n" ?>
    <?php echo __('Your login details are:')."\n" ?>
    <?php echo __('Email');?>: <?php echo $user->email."\n" ?>
    <?php echo __('Username');?>: <?php echo $user->username."\n" ?>
    <?php if(isset($user->password)&&!preg_match("/\$[\w\W]{1,10}\$[\w\W]{1,10}\$.*$/i", $user->password)):?>
    <?php echo __('Password');?>: <?php echo $user->password."\n" ?>
    <?php endif; ?>
    <?php echo __('Thank You');?>
    <?= $this->Url->build('/', true) ?>
