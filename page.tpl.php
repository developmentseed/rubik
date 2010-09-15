<div id='branding'><div class='limiter clearfix'>
  <div class='breadcrumb clearfix'><?php print $breadcrumb ?></div>
  <?php if ($user_links) print theme('links', array('links' => $user_links)) ?>
</div></div>

<div id='page-title'><div class='limiter clearfix'>
  <?php if ($primary_local_tasks): ?>
    <div class='primary-tabs clearfix'>
      <ul class='links clearfix'><?php print render($primary_local_tasks) ?></ul>
    </div>
  <?php endif; ?>
  <h1 class='page-title <?php print $page_icon_class ?>'>
    <?php if (!empty($page_icon_class)): ?><span class='icon'></span><?php endif; ?>
    <?php if ($title) print $title ?>
  </h1>
  <?php if ($action_links): ?>
    <div class='action-links clearfix'>
      <ul class='links clearfix'><?php print render($action_links) ?></ul>
    </div>
  <?php endif; ?>
</div></div>

<?php if ($secondary_local_tasks): ?>
<div id='page-tools'><div class='limiter clearfix'>
  <div class='secondary-tabs clearfix'>
    <ul class='links clearfix'><?php print render($secondary_local_tasks) ?></ul>
  </div>
</div></div>
<?php endif; ?>

<div id='page'><div class='limiter clearfix'>
  <?php if ($page['help']) print $page['help'] ?>
  <div id='main-content' class='page-content clearfix'>
    <?php if ($show_messages && $messages): ?>
      <div id='console' class='clearfix'><?php print $messages; ?></div>
    <?php endif; ?>

    <div id='content'>
      <?php if (!empty($page['content'])): ?>
        <div class='content-wrapper clearfix'><?php print render($page['content']) ?></div>
      <?php endif; ?>
    </div>
  </div>
</div></div>

<div id='footer' class='clearfix'>
  <?php if ($feed_icons): ?>
    <div class='feed-icons clearfix'>
      <label><?php print t('Feeds') ?></label>
      <?php print $feed_icons ?>
    </div>
  <?php endif; ?>
</div>
