<div class='form form-layout-default clear-block'>
  <div class='column-main'><div class='column-wrapper clear-block'>
    <?php print drupal_render_children($form); ?>
    <div class='buttons'><?php print rubik_render_clone($actions); ?></div>
  </div></div>
  <div class='column-side'><div class='column-wrapper clear-block'>
    <div class='buttons'><?php print drupal_render($actions); ?></div>
    <?php print drupal_render($sidebar); ?>
  </div></div>
  <?php if (!empty($footer)): ?>
    <div class='column-footer'><div class='column-wrapper clear-block'><?php print drupal_render($footer); ?></div></div>
  <?php endif; ?>
</div>
