<p><?= __('Hi {0},', $user->username );?></p>

<p>
    <?php echo __('You or someone reset password at our site {0}', $this->Html->link($this->Url->build('/', true), $this->Url->build('/', true), ['escape' => false]));?>
</p>
<p>
    <?php echo __('Your login details are:');?><br />
    <?php echo __('Email');?>: <?php echo $user->email ?><br />
    <?php echo __('Username');?>: <?php echo $user->username ?><br />
    <?php if(isset($user->password)&&!preg_match("/\$[\w\W]{1,10}\$[\w\W]{1,10}\$.*$/i", $user->password)):?>
        <?php echo __('Password');?>: <?php echo $user->password ?>
    <?php endif; ?>
</p>
<p>
    <?php echo __('If you think that this email is spam just skip this message');?>
</p>
<p>
    <?php echo __('Thank You');?><br/>
    <?= $this->Html->link($this->Url->build('/', true), $this->Url->build('/', true), ['escape' => false])?>
</p>
