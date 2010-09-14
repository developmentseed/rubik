<div id='branding' class='clear-block'>
  <div class='breadcrumb clear-block'><?php print $breadcrumb ?></div>
  <?php if ($user_links) print theme('links', array('links' => $user_links)) ?>
</div>

<div id='page-title' class='clear-block'>
  <?php if ($help_toggler) print $help_toggler ?>
  <?php if ($primary_local_tasks): ?>
    <div class='primary-tabs clearfix'>
      <ul class='links clearfix'><?php print render($primary_local_tasks) ?></ul>
    </div>
  <?php endif; ?>
  <h1 class='page-title <?php print $page_icon_class ?>'>
    <?php if (!empty($page_icon_class)): ?><span class='icon'></span><?php endif; ?>
    <?php if ($title) print $title ?>
  </h1>
</div>

<div id='page'>
  <?php if ($secondary_local_tasks): ?>
    <div class='secondary-tabs clearfix'>
      <ul class='links clearfix'><?php print render($secondary_local_tasks) ?></ul>
    </div>
  <?php endif; ?>

  <?php if ($help) print $help ?>
  <div id='main-content' class='page-content clear-block'>
    <?php if ($show_messages && $messages): ?>
      <div id='console' class='clear-block'><?php print $messages; ?></div>
    <?php endif; ?>

    <div id='content'>
      <?php if (!empty($page['content'])): ?>
        <div class='content-wrapper clear-block'><?php print render($page['content']) ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div id='footer' class='clear-block'>
  <?php if ($feed_icons): ?>
    <div class='feed-icons clear-block'>
      <label><?php print t('Feeds') ?></label>
      <?php print $feed_icons ?>
    </div>
  <?php endif; ?>
</div>
