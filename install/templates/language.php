<?php $this->layout('base');  ?>

<form id="install" action="" method="post">

    <?php if ($restarted): ?>
    <br class="clear" />
    <br class="clear" />
    <p class="note"><?=$_lang['restarted_msg']?></p>
    <?php endif ?>

    <div class="setup_navbar" style="border-top: 0;">
        <p class="title"><?=$_lang['choose_language']?>:
            <select name="language" autofocus="autofocus">
                <?php foreach ($languages as $lang): ?>
                <option value="<?=$lang?>"<?php if ($lang === $currentLang): ?> selected<?php endif ?>><?=$lang?></option>
                <?php endforeach ?>
            </select>
        </p>

        <input type="submit" value="<?=$_lang['select']?>" />
    </div>
</form>

