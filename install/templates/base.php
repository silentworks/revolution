<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?=$app_name?> <?=$app_version?> &raquo; <?=$_lang['install']?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="<?=$this->root_path()?>/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=$this->root_path()?>/install/assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=$this->root_path()?>/install/assets/css/text.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=$this->root_path()?>/install/assets/css/960.css" />

    <link rel="stylesheet" type="text/css" media="screen" href="<?=$this->root_path()?>/install/assets/modx.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?=$this->root_path()?>/install/assets/css/print.css" />

    <link rel="stylesheet" type="text/css" href="<?=$this->root_path()?>/install/assets/css/style.css" />
    <?php if (! empty($_lang['additional_css'])): ?>
    <style type="text/css"><?=$_lang['additional_css']?></style>
    <?php endif ?>
</head>

<body>
<!-- start header -->
<div id="header">
    <div class="container_12">
        <div id="metaheader">
            <div class="grid_6">
                <div id="mainheader">
                    <h1 id="logo" class="pngfix"><span><?=$app_name?></span></h1>
                </div>
            </div>
            <div id="metanav" class="grid_6">
                <a href="#"><strong><?=$app_name?></strong>&nbsp;<em><?=$_lang['version']?> <?=$app_version?></em></a>
            </div>
        </div>
        <div class="clear">&nbsp;</div>
    </div>
</div>
<!-- end header -->

<div id="contentarea">
    <div class="container_16">
        <!-- start content -->
        <div id="content" class="grid_12">

            <?=$this->section('content')?>

        </div>
        <!-- end content -->
        <div class="clear">&nbsp;</div>
    </div>
</div>

<!-- start footer -->
<div id="footer">
    <div id="footer-inner">
        <div class="container_12">
            <p><?=$_lang['modx_footer1']?></p>
            <p><?=$_lang['modx_footer2']?></p>
        </div>
    </div>
</div>

<div class="post_body">

</div>
<!-- end footer -->
</body>
</html>