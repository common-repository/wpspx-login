<?php
if (!defined( 'ABSPATH' ) ) die( 'Forbidden' );


/*=============================
=            LOGIN            =
=============================*/

function wpspx_login() {
?><div class="accountbox modal">
	<div style="display:none;" class="wpspx-spektrix-base" data-wpspx-spektrix-base="<?php echo WPSPX_SPEKTRIX_API_URL ?>"></div>
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">Login to your account</p>
			<button class="delete" aria-label="close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></i></button>
		</header>
		<section class="modal-card-body">
			<div class="formcontent"></div>
		</section>
		<footer class="modal-card-foot">
		</footer>
	</div>
</div>
<script>
	if (sessionStorage.getItem('spektrix_auth') === 'success') {
        let spektrixuserid = null;
        let userdetailssettings = {
            "async": true,
            "crossDomain": true,
            "url": "<?php echo WPSPX_SPEKTRIX_API_URL; ?>customer",
            "method": "GET",
            "xhrFields": {
                "withCredentials": true
            },
            "headers": {
                "Content-Type": "application/json",
                "cache-control": "no-cache"
            },
            "statusCode": {
                401: function (error) {
                    // simply ignore this error
                }
            },
            "processData": false
        }
        jQuery.ajax(userdetailssettings).done(function (userdetailsresponse) {
            if (typeof userdetailsresponse.id !== 'undefined' && userdetailsresponse.id !== '') {
                spektrixuserid = userdetailsresponse.id;
                jQuery('.menu-item-wpspx-login').html('<a class="is-info" title="View my Accont" href="/my-account">My Account</a>'
                );

            }
        }).fail(function (xhr, status, error) {
            jQuery('.menu-item-wpspx-login').html('<a class="loginlink" onclick="wpspxLogin()">Log in</a>');
        });

    }
</script>
<?php
}
add_action( 'wp_footer', 'wpspx_login', 99);

function wpspx_login_link()
{
	echo '<a class="loginlink button is-primary" onclick="wpspxLogin()">Log in</a>';
}
add_shortcode( 'wpspx_login_link', 'wpspx_login_link' );



function wpspx_custom_login_link ( $items, $args ) {
	$options = get_option( 'wpspx_login_settings' );
	if ($args->theme_location == $options['wpspx_login_link_location'] ) {
		$items .= '<li id="menu-item-wpspx-login" class="menu-item menu-item-wpspx-login"><a class="loginlink" onclick="wpspxLogin()">Log in</a></li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'wpspx_custom_login_link', 10, 2 );
