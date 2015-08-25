<?php $this->layout('base');  ?>

<script type="text/javascript" src="assets/js/sections/welcome.js"></script>
<form id="welcome" action="?action=welcome" method="post">
    <div>
        <h2><?=$_lang['welcome']?></h2>
        <?=$_lang['welcome_message']?>
        <br />
    </div>

    <?php if (MODX_SETUP_KEY !== '@traditional@') : ?>
    <p><?=$_lang['config_key_change']?></p>

    <div id="cck-div">
        <h3><?=$_lang['config_key']?></h3>
        <p><small><?=$_lang['config_key_override']?></small></p>
        <div class="labelHolder">
            <label for="config_key"><?=$_lang['config_key']?></label>
            <input type="text" name="config_key" id="config_key" value="<?=$config_key?>" style="width:250px" />
            <br />
            <?php if ($writableError): ?>
            <span class="field_error"><?=$_lang['config_not_writable_err']?></span>
            <?php endif ?>
        </div>
    </div>
    <?php endif ?>
    <div class="setup_navbar">
        <input type="submit" name="proceed" value="<?=$_lang['next']?>" autofocus="autofocus" />
    </div>
</form>

