<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ReplayBird {

	/**
	 * @var Const Plugin Release Date
	 */
	const RELEASE_DATE = '20221103';

	public function __construct()
	{

	}

	public function init()
	{
		$this->init_admin();
    	$this->enqueue_script();
    	$this->enqueue_admin_styles();
	}

	public function init_admin() {
		register_setting( 'replaybird', 'replaybird_site_key' );
    	add_action( 'admin_menu', array( $this, 'create_nav_page' ) );
	}

	public function create_nav_page() {
		add_options_page(
		  esc_html__( 'ReplayBird', 'replaybird' ),
		  esc_html__( 'ReplayBird', 'replaybird' ),
		  'manage_options',
		  'replaybird_settings',
		  array($this,'admin_view')
		);
	}

	public static function admin_view()
	{
		require_once plugin_dir_path( __FILE__ ) . '/settings.php';
	}

	public static function replaybird_script()
	{
		$replaybird_site_key = get_option( 'replaybird_site_key' );
		$is_admin = is_admin();

		$replaybird_site_key = trim($replaybird_site_key);
		if (!$replaybird_site_key) {
			return;
		}

		if ( $is_admin ) {
			return;
		}

		echo "
			<script>
				!function(t,e){var o,n,p,r;e.__SV||(window.replaybird=e,e._i=[],e.init=function(i,s,a){function g(t,e){var o=e.split('.');2==o.length&&(t=t[o[0]],e=o[1]),t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}}(p=t.createElement('script')).type='text/javascript',p.async=!0,p.src='https://cdn.replaybird.com/agent/latest/replaybird.js',(r=t.getElementsByTagName('script')[0]).parentNode.insertBefore(p,r);var u=e;for(void 0!==a?u=e[a]=[]:a='replaybird',u.people=u.people||[],u.toString=function(t){var e='replaybird';return'replaybird'!==a&&(e+='.'+a),t||(e+=' (stub)'),e},u.people.toString=function(){return u.toString(1)+'.people (stub)'},o='identify capture alias people.set people.set_once set_config register register_once unregister opt_out_capturing has_opted_out_capturing opt_in_capturing reset'.split(' '),n=0;n<o.length;n++)g(u,o[n]);e._i.push([i,s,a])},e.__SV=1)}(document,window.replaybird||[]);
				replaybird.init('" . $replaybird_site_key . "', { });
			</script>
		";
		// <!-- ReplayBird Wordpress Tracking Code -->
	}

	private function enqueue_script() {
		add_action( 'wp_head', array($this, 'replaybird_script') );
	}

    private function enqueue_admin_styles() {
        add_action( 'admin_enqueue_scripts', array($this, 'replaybird_admin_styles' ) );
    }

    public static function replaybird_admin_styles() {
        wp_register_style( 'replaybird_custom_admin_style', plugins_url( '../styles/index.css', __FILE__ ), array(), self::RELEASE_DATE, 'all' );
        wp_enqueue_style( 'replaybird_custom_admin_style' );
    }

}

?>
