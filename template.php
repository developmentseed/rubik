<?php
// $Id$

/**
 * Implementation of hook_theme().
 */
function rubiks_theme() {
  return array(
    'node' => array(
      'template' => 'object',
      'path' => path_to_theme() .'/templates',
    ),
    'comment' => array(
      'template' => 'object',
      'path' => path_to_theme() .'/templates',
    ),
    'comment_wrapper' => array(
      'template' => 'object',
      'path' => path_to_theme() .'/templates',
    ),
    'confirm_form' => array(
      'arguments' => array('form' => array()),
      'path' => path_to_theme() .'/templates',
      'template' => 'form-confirm',
    ),
    'node_form' => array(
      'arguments' => array('form' => array()),
      'path' => path_to_theme() .'/templates',
      'template' => 'form-default',
    ),
    'node_type_form' => array(
      'arguments' => array('form' => array()),
      'path' => path_to_theme() .'/templates',
      'template' => 'form-default',
    ),
    'system_settings_form' => array(
      'arguments' => array('form' => array()),
      'path' => path_to_theme() .'/templates',
      'template' => 'form-default',
    ),
    'user_profile_form' => array(
      'arguments' => array('form' => array()),
      'path' => path_to_theme() .'/templates',
      'template' => 'form-default',
    ),
  );
}

/**
 * Preprocessor for theme('page').
 */
function rubiks_preprocess_page(&$vars) {
  $vars['attr']['class'] .= ' admin-static';
}

/**
 * Preprocessor for theme('fieldset').
 */
function rubiks_preprocess_fieldset(&$vars) {
  if (!empty($vars['element']['#collapsible'])) {
    $vars['title'] = "<span class='icon'></span>" . $vars['title'];
  }
}

/**
 * Do preprocess form button handling for most forms.
 */
function _rubiks_process_form_buttons(&$vars) {
  if (isset($vars['form']['buttons'])) {
    $vars['buttons'] = $vars['form']['buttons'];
    unset($vars['form']['buttons']);
  }
  else {
    $vars['buttons'] = array();
    $keys = array('save', 'submit', 'delete', 'reset');
    foreach ($keys as $key) {
      if (isset($vars['form'][$key], $vars['form'][$key]['#type']) && $vars['form'][$key]['#type'] == 'submit') {
        $vars['buttons'][$key] = $vars['form'][$key];
        unset($vars['form'][$key]);
      }
    }
  }
}

/**
 * Preprocessor for theme('node_form').
 */
function rubiks_preprocess_node_form(&$vars) {
  _rubiks_process_form_buttons($vars);

  // @TODO: Figure out a better way here. drupal_alter() is preferable.
  // Allow modules to insert form elements into the sidebar,
  // defaults to showing taxonomy in that location.
  $vars['sidebar'] = array();
  if (!$sidebar_fields = module_invoke_all('node_form_sidebar', $form, $form['#node'])) {
    $sidebar_fields = array('taxonomy');
  }
  foreach ($sidebar_fields as $field) {
    $vars['sidebar'][] = $vars['form'][$field];
    unset($vars['form'][$field]);
  }
}

/**
 * Preprocessor for theme('node_type_form').
 */
function rubiks_preprocess_node_type_form(&$vars) {
  _rubiks_process_form_buttons($vars);
}

/**
 * Preprocessor for theme('system_settings_form').
 */
function rubiks_preprocess_system_settings_form(&$vars) {
  _rubiks_process_form_buttons($vars);
}

/**
 * Preprocessor for theme('user_profile_form').
 */
function rubiks_preprocess_user_profile_form(&$vars) {
  _rubiks_process_form_buttons($vars);
}

/**
 * Override of theme('breadcrumb').
 */
function rubiks_breadcrumb($breadcrumb) {
  $output = '';
  if (empty($breadcrumb)) {
    $breadcrumb = array(variable_get('site_name', ''));
  }
  else {
    $site_link = l(variable_get('site_name', ''), '<front>');
    $item = menu_get_item();
    $breadcrumb[] = $item['title'];
  }
  foreach ($breadcrumb as $link) {
    if (isset($site_link) && strip_tags($link) === t('Home')) {
      $link = $site_link;
    }
    $output .= "<span class='breadcrumb-link'>{$link}</span>";
  }
  return $output;
}

/**
 * Display the list of available node types for node creation.
 */
function rubiks_node_add_list($content) {
  $output = '';
  if ($content) {
    $output = '<ul class="node-type-list">';
    foreach ($content as $item) {
      $output .= "<li class='clear-block'>";
      $output .= '<label>'. l($item['title'], $item['href'], $item['localized_options']) .'</label>';
      $output .= '<div class="description">'. filter_xss_admin($item['description']) .'</div>';
      $output .= "</li>";
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Override of theme_admin_block_content().
 */
function rubiks_admin_block_content($content, $get_runstate = FALSE) {
  static $has_run = FALSE;
  if ($get_runstate) {
    return $has_run;
  }
  $has_run = TRUE;
  $output = '';
  if (!empty($content)) {
    foreach ($content as $k => $item) {
      $id = str_replace('/', '-', $item['href']);
      $class = ' path-'. $id;

      $content[$k]['title'] = "<span class='icon'></span>{$item['title']}";
      $content[$k]['localized_options']['html'] = TRUE;
      if (!empty($content[$k]['localized_options']['attributes']['class'])) {
        $content[$k]['localized_options']['attributes']['class'] .= $class;
      }
      else {
        $content[$k]['localized_options']['attributes']['class'] = $class;
      }
    }
    $output = system_admin_compact_mode() ? '<ul class="menu">' : '<ul class="admin-list">';
    foreach ($content as $item) {
      $output .= '<li class="leaf">';
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      if (!system_admin_compact_mode()) {
        $output .= "<div class='description'>{$item['description']}</div>";
      }
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Theme function for manage options on admin/content/node, admin/user/user.
 */
function rubiks_admin_manage_options($form) {
  $output = "<div class='clear-block admin-options'>";
  $output .= "<label>{$form['#title']}</label>";
  foreach (element_children($form) as $id) {
    $output .= drupal_render($form[$id]);
  }
  $output .= "</div>";
  return $output;
}

/**
 * Override of theme('textfield').
 */
function rubiks_textfield($element) {
  if ($element['#size'] >= 40) {
    $element['#size'] = '';
    $element['#attributes']['class'] = isset($element['#attributes']['class']) ? "{$element['#attributes']['class']} fluid" : "fluid";
  }
  return theme_textfield($element);
}

/**
 * Preprocessor for theme('node').
 */
function rubiks_preprocess_node(&$vars) {
  $vars['layout'] = TRUE;
  $vars['title'] = menu_get_object() === $vars['node'] ? '' : $vars['title'];
  $vars['attr']['class'] .= ' clear-block';
}

/**
 * Override of theme('node_submitted').
 */
function rubiks_node_submitted($node) {
  return _rubiks_submitted($node);
}

/**
 * Override of theme('comment_submitted').
 */
function rubiks_comment_submitted($comment) {
  $vars = $comment;
  $vars->created = $comment->timestamp;
  return _rubiks_submitted($comment);
}

/**
 * Helper function to submitted info theming functions.
 */
function _rubiks_submitted($node) {
  $byline = t('Posted by !username', array('!username' => theme('username', $node)));
  $date = format_date($node->created, 'small');
  return "<span class='byline'>{$byline}</span><span class='date'>$date</span>";
}

/**
 * Preprocessor for theme('comment').
 */
function rubiks_preprocess_comment(&$vars) {
  $vars['layout'] = TRUE;
  $vars['attr']['class'] .= ' clear-block';
}

/**
 * Preprocessor for theme('comment_wrapper').
 */
function rubiks_preprocess_comment_wrapper(&$vars) {
  $vars['hook'] = 'box';
  $vars['title'] = t('Comments');

  $vars['attr']['id'] = 'comments';
  $vars['attr']['class'] .= ' clear-block';
}

/**
 * Preprocessor for theme('confirm_form').
 */
function rubiks_preprocess_confirm_form(&$vars) {
  $vars['title'] = drupal_get_title();
  drupal_set_title(t('Please confirm'));
}
