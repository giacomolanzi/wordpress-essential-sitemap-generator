/* ------------------------------------------------------------------------- *
* WordPress Essential Dynamic XML Sitemap generator
* 
/* ------------------------------------------------------------------------- */
add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");
function eg_create_sitemap() {
$postsForSitemap = get_posts(array(
'numberposts' => -1,
'orderby' => 'modified',
'post_type' => array('post','page'),
'order' => 'DESC'
));
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap .= '<?xml-stylesheet type="text/xsl" href="sitemap-style.xsl"?>';
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
foreach($postsForSitemap as $post) {
setup_postdata($post);
$postdate = explode(" ", $post->post_modified);
$sitemap .= '<url>'.
'<loc>'. get_permalink($post->ID) .'</loc>'.
'<priority>1</priority>'.
'<lastmod>'. $postdate[0] .'</lastmod>'.
'<changefreq>daily</changefreq>'.
'</url>';
}
$sitemap .= '</urlset>';
$fp = fopen(ABSPATH . "sitemap.xml", 'w');
fwrite($fp, $sitemap);
fclose($fp);
}
