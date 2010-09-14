<div class='form form-layout-simple clear-block'>
  <?php print drupal_render_children($form) ?>
  <?php if ($buttons): ?>
    <div class='buttons'><?php print drupal_render_children($buttons) ?></div>
  <?php endif; ?>
</div>
