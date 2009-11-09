<?php
// $Id$

/**
 * Implementation of hook_theme().
 */
function rubiks_theme() {
  $items = array();

  // Content theming.
  $items['help'] =
  $items['comment'] =
  $items['node'] = array(
    'path' => path_to_theme() .'/templates',
    'template' => 'object',
  );

  // Form layout: simple.
  $items['filter_admin_overview'] =
  $items['user_admin_perm'] = array(
    'arguments' => array('form' => array()),
    'path' => path_to_theme() .'/templates',
    'template' => 'form-simple',
    'preprocess functions' => array(
      'rubiks_preprocess_form_buttons',
      'rubiks_preprocess_form_legacy'
    ),
  );

  // Form layout: default (2 column).
  $items['comment_form'] =
  $items['filter_admin_format_form'] =
  $items['menu_edit_menu'] =
  $items['menu_edit_item'] =
  $items['node_type_form'] =
  $items['system_settings_form'] =
  $items['system_themes_form'] =
  $items['system_modules'] =
  $items['system_actions_configure'] =
  $items['taxonomy_form_term'] =
  $items['taxonomy_form_vocabulary'] =
  $items['user_pass'] =
  $items['user_login'] =
  $items['user_register'] =
  $items['user_profile_form'] =
  $items['user_admin_access_add_form'] = array(
    'arguments' => array('form' => array()),
    'path' => path_to_theme() .'/templates',
    'template' => 'form-default',
    'preprocess functions' => array(
      'rubiks_preprocess_form_buttons',
      'rubiks_preprocess_form_legacy',
    ),
  );

  // These forms require additional massaging.
  $items['confirm_form'] = array(
    'arguments' => array('form' => array()),
    'path' => path_to_theme() .'/templates',
    'template' => 'form-simple',
    'preprocess functions' => array(
      'rubiks_preprocess_form_confirm'
    ),
  );
  $items['node_form'] = array(
    'arguments' => array('form' => array()),
    'path' => path_to_theme() .'/templates',
    'template' => 'form-default',
    'preprocess functions' => array(
      'rubiks_preprocess_form_buttons',
      'rubiks_preprocess_form_node'
    ),
  );

  return $items;
}

/**
 * Preprocessor for theme('page').
 */
function rubiks_preprocess_page(&$vars) {
  $vars['attr']['class'] .= ' admin-static';

  // Help text toggler link.
  $vars['help_toggler'] = l(t('Help'), $_GET['q'], array('attributes' => array('id' => 'help-toggler', 'class' => 'toggler'), 'fragment' => 'rubiks-help=1'));

  // Clear out help text if empty.
  if (empty($vars['help']) || !(strip_tags($vars['help']))) {
    $vars['help'] = '';
  }
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
 * Attempts to render a non-template based form for template rendering.
 */
function rubiks_preprocess_form_legacy(&$vars) {
  if (isset($vars['form']['#theme']) && function_exists("theme_{$vars['form']['#theme']}")) {
    $function = "theme_{$vars['form']['#theme']}";
    $vars['form'] = array(
      '#type' => 'markup',
      '#value' => $function($vars['form'])
    );
  }
}

/**
 * Preprocessor for handling form button for most forms.
 */
function rubiks_preprocess_form_buttons(&$vars) {
  if (isset($vars['form']['buttons'])) {
    $vars['buttons'] = $vars['form']['buttons'];
    unset($vars['form']['buttons']);
  }
  else {
    $vars['buttons'] = array();
    foreach (element_children($vars['form']) as $key) {
      if (isset($vars['form'][$key]['#type']) && in_array($vars['form'][$key]['#type'], array('submit', 'button'))) {
        $vars['buttons'][$key] = $vars['form'][$key];
        unset($vars['form'][$key]);
      }
    }
  }
}

/**
 * Preprocessor for theme('confirm_form').
 */
function rubiks_preprocess_form_confirm(&$vars) {
  // Move the title from the page title (usually too big and unwieldy)
  $title = filter_xss_admin(drupal_get_title());
  $vars['form']['description']['#type'] = 'item';
  $vars['form']['description']['#value'] = empty($vars['form']['description']['#value']) ?
    "<strong>{$title}</strong>" :
    "<strong>{$title}</strong><p>{$vars['form']['description']['#value']}</p>";
  drupal_set_title(t('Please confirm'));

  // Button setup
  $vars['buttons'] = $vars['form']['actions'];
  unset($vars['form']['actions']);
}

/**
 * Preprocessor for theme('node_form').
 */
function rubiks_preprocess_form_node(&$vars) {
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
 * Preprocessor for theme('help').
 */
function rubiks_preprocess_help(&$vars) {
  $vars['hook'] = 'help';
  $vars['attr']['id'] = 'rubiks-help';
  $vars['attr']['class'] .= ' clear-block toggleable';
  $help = menu_get_active_help();
  if (($test = strip_tags($help)) && !empty($help)) {
    // Thankfully this is static cached.
    $vars['attr']['class'] .= menu_secondary_local_tasks() ? ' with-tabs' : '';

    $vars['is_prose'] = TRUE;
    $vars['layout'] = TRUE;
    $vars['content'] = $help;
    $vars['links'] = '<label class="breadcrumb-label">'. t('Help text for') .'</label>';
    $vars['links'] .= theme('breadcrumb', drupal_get_breadcrumb(), FALSE);
  }
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
 * Override of theme('breadcrumb').
 */
function rubiks_breadcrumb($breadcrumb, $prepend = TRUE) {
  $output = '';

  // Add current page onto the end.
  if (!drupal_is_front_page()) {
    $item = menu_get_item();
    $breadcrumb[] = check_plain($item['title']);
  }

  // Remove the home link.
  foreach ($breadcrumb as $key => $link) {
    if (strip_tags($link) === t('Home')) {
      unset($breadcrumb[$key]);
      break;
    }
  }

  // Optional: Add the site name to the front of the stack.
  if ($prepend) {
    $site_name = empty($breadcrumb) ? check_plain(variable_get('site_name', '')) : l(variable_get('site_name', ''), '<front>');
    array_unshift($breadcrumb, $site_name);
  }

  foreach ($breadcrumb as $link) {
    $output .= "<span class='breadcrumb-link'>{$link}</span>";
  }
  return $output;
}

/**
 * Display the list of available node types for node creation.
 */
function rubiks_node_add_list($content) {
  $output = "<ul class='admin-list'>";
  if ($content) {
    foreach ($content as $item) {
      $output .= "<li>";
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      $output .= '<div class="description">'. filter_xss_admin($item['description']) .'</div>';
      $output .= "</li>";
    }
  }
  $output .= "</ul>";
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
 * Override of theme('textfield').
 */
function rubiks_textfield($element) {
  if ($element['#size'] >= 30) {
    $element['#size'] = '';
    $element['#attributes']['class'] = isset($element['#attributes']['class']) ? "{$element['#attributes']['class']} fluid" : "fluid";
  }
  return theme_textfield($element);
}

/**
 * Override of theme('password').
 */
function rubiks_password($element) {
  if ($element['#size'] >= 30 || $element['#maxlength'] >= 30) {
    $element['#size'] = '';
    $element['#attributes']['class'] = isset($element['#attributes']['class']) ? "{$element['#attributes']['class']} fluid" : "fluid";
  }
  return theme_password($element);
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
