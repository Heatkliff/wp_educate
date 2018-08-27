<?php

get_header();
if (get_option('educate_options')['sidebar'] == 'val1'){
    get_template_part('/template/post-with-sidebar');
}else{
    get_template_part('/template/post-without-sidebar');
}
?>



<?php get_footer(); ?>