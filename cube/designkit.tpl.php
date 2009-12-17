<style type='text/css'>
div.block h2.block-title,
#page-title ul.links li.active a,
#page-title ul.links li a.active {
  background-color:<?php print $background ?>;
  }

div.pager li.pager-current,
#tabs div.page-tabs li.active a,
#tabs div.page-tabs li a.active {
  background-color:<?php print $background ?>;
  }

input.form-submit:hover {
  border-color:<?php print designkit_colorshift($background, '#000000', .2) ?>;
  border-bottom-color:<?php print designkit_colorshift($background, '#000000', .4) ?>;
  background-color:<?php print $background ?>;
  }
</style>
