<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <?php print $styles ?>
    <title><?php print $head_title ?></title>
  </head>
  <body class='rubiks layout-default admin-static' <?php // print drupal_attributes($attr) ?>>

  <?php if ($admin) print $admin ?>

  <?php if ($help): ?>
    <div id='help' class='reverse limiter'>
      <div class='help-label'><?php print t('Help') ?></div>
      <div class='help-wrapper clear-block limiter'><?php print $help; ?></div>
    </div>
  <?php endif; ?>

  <div id='branding'><div class='clear-block limiter'>
    <div class='breadcrumb clear-block'><?php print $breadcrumb ?></div>
    <!--
    <?php if ($site_name): ?><h1 class='site-name'><?php print $site_name ?></h1><?php endif; ?>
    -->
  </div></div>

  <div id='page-title' class='clear-block limiter'>
    <?php if ($tabs): ?><?php print $tabs ?><?php endif; ?>
    <h2 class='page-title'><?php if ($title) print $title ?></h2>
  </div>

  <div id='page'><div class='clear-block limiter'>

    <?php if ($tabs2): ?><div class='secondary-tabs clear-block'><?php print $tabs2 ?></div><?php endif; ?>

    <?php if ($show_messages && $messages): ?>
      <div id='console' class='clear-block'><?php print $messages; ?></div>
    <?php endif; ?>

    <div id='content' class='clear-block'>
      <div class='page-content'><?php print $content ?></div>
    </div>

  </div></div>

  <div id="footer">
    <?php print $feed_icons ?>
    <?php print $footer ?>
    <?php print $footer_message ?>
  </div>

  <?php print $scripts ?>
  <?php print $closure ?>

  </body>
</html>
