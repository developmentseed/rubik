<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <?php print $styles ?>
    <title><?php print $head_title ?></title>
  </head>
  <body class='layout-default admin-static' <?php // print drupal_attributes($attr) ?>>

  <?php if ($admin) print $admin ?>

  <?php if ($help): ?>
    <div id='help' class='reverse limiter'>
      <div class='help-label'><?php print t('Help') ?></div>
      <div class='help-wrapper clear-block limiter'><?php print $help; ?></div>
    </div>
  <?php endif; ?>

  <div id='branding'><div class='clear-block limiter'>
    <?php if ($site_name): ?><h1 class='site-name'><?php print $site_name ?></h1><?php endif; ?>
  </div></div>

  <div id='page-title' class='clear-block limiter'>
    <?php if ($tabs): ?><ul class='tabs primary'><?php print $tabs ?></ul><?php endif; ?>
    <?php if ($title): ?><h2 class='page-title'><?php print $title ?></h2><?php endif; ?>
  </div>

  <div id='page'><div class='clear-block limiter'>

    <?php if ($tabs2): ?><ul class='tabs secondary'><?php print $tabs2 ?></ul><?php endif; ?>

    <?php if ($show_messages && $messages): ?>
      <div id='console' class='clear-block'><?php print $messages; ?></div>
    <?php endif; ?>

    <div id='content' class='clear-block'>
      <div class='content-top clear-block'>
        <div id='nw'><?php print $nw ?></div>
        <div id='ne'><?php print $ne ?></div>
      </div>
      <div class='content-middle clear-block'>
        <div id='w'><?php print $w ?></div>
        <div id='e'><?php print $e ?></div>
      </div>
      <div class='content-bottom clear-block'>
        <div class='page-content'><?php print $content ?></div>
      </div>
    </div>

    <div id="footer">
      <?php print $feed_icons ?>
      <?php print $footer ?>
      <?php print $footer_message ?>
    </div>

  </div></div>

  <?php print $scripts ?>
  <?php print $closure ?>

  </body>
</html>
