<div class='form-confirm'>

<div class='form-item'>
  <?php if (!empty($title)): ?>
    <h2 class='form-title'><?php print $title ?></h2>
  <?php endif; ?>

  <?php $message = drupal_render($form['description']) ?>
  <?php if (!empty($message)) print $message ?>
</div>

<div class='buttons'><?php print drupal_render($form['actions']) ?></div>

<?php print drupal_render($form) ?>

</div>