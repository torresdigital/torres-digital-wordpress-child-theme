<?php

/* Theme Name: --- by 🌟Torres Digital®

Theme URI: https://www.facebook.com/torresdigital/

    Author: Torres Digital® | Sites → Lojas Virtuais e e-Commerce
    Author URI: https://www.facebook.com/torresdigital/

    Description: omos uma Agência Gaúcha que trabalha com Desenvolvimento Web voltado para todos os Nichos do Mercado tais como os de insumos, commodities, pequenos, médios e grandes Lojistas que desejam alcançar mais Clientes através do e-Commerce: Sites, Aplicativos, Lojas Virtuais, Marketplaces, WordPress e Woocommerce, integrados com os Principais Cartões e Soluções de Pagamentos do Brasil e do Mundo; tais como Cielo, CyberSource, PagSeguro, Stripe, Vindi, MasterCard, Visa, American Express, outros.

    Torres Digital também conta com toda uma Equipe e um Know-how forte, amplo, e moderno e conceitual para a organização e criação de todo um Portifólio para Publicidade e Propaganda.
    
    www.torresdigital.com.br * Menos é mais.

    Text Domain: torresdigital
    Template: torresdigital
    Version: 2.0 *//*

License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tags: child theme, woocommerce
Text Domain: torresdigital
This theme, like WordPress, is licensed under the GPL. Use it to make something cool, have fun, and share what you’ve learned with others.  */

/*All Begin*/


function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/* registrando scripts */
add_action("wp_enqueue_scripts", "scripts");
function myscripts() { 
    wp_register_script('tdwct', 
                        get_template_directory_uri() .'/scripts.js',   //
                        array ('jquery', 'jquery-ui'),                  //depends on these, however, they are registered by core already, so no need to enqueue them.
                        false, false);
    wp_enqueue_script('tdwct');
      
}

/****
    * Registrando Scripts v.2 *
    */

/* Registrando Scripts v.2 *
function my_enqueue_scripts()
{
    wp_register_script( 'first', get_template_directory_uri() . 'js/first.js' );
 
    wp_enqueue_script( 'second', get_template_directory_uri() . 'js/second.js', array( 'first' ) );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' ); 

*/


/****
    * Registrando Scripts v.3 *
    */

/* Registrando Scripts v.3 *

function myscripts() {
    //get some external script that is needed for this script
    wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js'); 
    $script = get_template_directory_uri() . '/library/myscript.js';
    wp_register_script('myfirstscript', 
                        $script, 
                        array ('jquery', 'jquery-ui'), 
                        false, false);
    //always enqueue the script after registering or nothing will happen
    wp_enqueue_script('fullpage-slimscroll');
     
}
add_action("wp_enqueue_scripts", "myscripts");

/**
    * Change the login page icon and URL to our site instead of WordPress.org
    */
    add_filter( 'login_headerurl', 'xs_login_headerurl' );
    function xs_login_headerurl( $url ) {
    return esc_url(  'https://www.torresdigital.tk.'  );
    }
    add_filter( 'login_headertitle', 'xs_login_headertitle' );
    function xs_login_headertitle( $title ) {
    return get_bloginfo ( 'name' ) . ' – ' . get_bloginfo ( 'description' );
    }


/* Outros */

 /** Font Awesome, by Torres Digital */
  function theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'my-child-fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
    /**
     * Order product collections by stock status, instock products first.
     * https://stackoverflow.com/questions/25113581/show-out-of-stock-products-at-the-end-in-woocommerce
     */
    class iWC_Orderby_Stock_Status
    {

        public function __construct()
        {
            // Check if WooCommerce is active
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
            }
        }

        public function order_by_stock_status($posts_clauses)
        {
            global $wpdb;
            // only change query on WooCommerce loops
            if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())) {
                $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
                $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
                $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
            }
            return $posts_clauses;
        }
    }

    new iWC_Orderby_Stock_Status;


    /*

    function child_shophistic_theme_enqueue_styles() {

	//First we load Bootstrap from parent, then parent styles and then child styles
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ) );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );

    }
    add_action( 'wp_enqueue_scripts', 'child_shophistic_theme_enqueue_styles' );

    register_sidebar( array(
    'name' => 'Footer Sidebar 1',
    'id' => 'footer-sidebar-1',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
    register_sidebar( array(
    'name' => 'Footer Sidebar 2',
    'id' => 'footer-sidebar-2',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
    register_sidebar( array(
    'name' => 'Footer Sidebar 3',
    'id' => 'footer-sidebar-3',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
    register_sidebar( array(
    'name' => 'Footer Sidebar 4',
    'id' => 'footer-sidebar-4',
    'description' => 'Appears in the footer area',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );


    function my_login_logo_one() {  ?> 
        <style type="text/css"> 
        body.login div#login h1 a {
            background-image: url(/wp-content/uploads/2018/10/logo-sites-torresdigital.png);
            background-size: 70%;
            width: 100%;
            height: 237px;
            text-align: center;
            position: relative;
            margin: 0 auto;
            left: 17px;
                                    }
        </style> 
    <?php  } add_action( 'login_enqueue_scripts', 'my_login_logo_one' );
