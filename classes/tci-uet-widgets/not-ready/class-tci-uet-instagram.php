<?php
/**
 * TCI UET Instagram widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TCI_UET_Instagram extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Instagram';
	}

	/**
	 * Get widget title.
	 * Retrieve widget title.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'TCI UET Instagram', 'tci-uet' );
	}

	/**
	 * Get widget icon.
	 * Retrieve widget icon.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'tci-uet-ver tci tci-';
	}

	/**
	 * Get widget categories.
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'tci-uet-global-widget' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'instagram' ];
	}

	/**
	 * Get script dependencies.
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Element script dependencies.
	 */
	public function get_script_depends() {
		return [
			'tci-uet-typeit',
		];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'_section_media',
			[
				'label' => __( 'Layout', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'access_token',
			[
				'label'       => __( 'Access Token', 'tci-uet' ),
				'description' => sprintf( __( 'You have not set Access Token. Please click here to %s', 'tci-uet' ), '<a target="_self" href="https://instagram.pixelunion.net/">' . __( 'Set Access Token', 'tci-uet' ) . '</a>' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '2238066121.1677ed0.45866c4b89b14e469023426bbc23b744',
			]
		);

		$this->add_control(
			'feed_columns',
			[
				'label'              => __( 'Columns', 'tci-uet' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '3',
				'options'            => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
				],
				'prefix_class'       => 'elementor-grid-',
				'frontend_available' => true,
				'separator'          => 'before',
			]
		);

		$this->add_control(
			'number_of_images',
			[
				'label'   => __( 'Number of Images', 'tci-uet' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label'   => __( 'Image Size', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard_resolution',
				'options' => [
					'standard_resolution' => esc_html__( 'Standard', 'tci-uet' ),
					'low_resolution'      => esc_html__( 'Medium', 'tci-uet' ),
					'thumbnail'           => esc_html__( 'Small', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'show_likes',
			[
				'label'     => __( 'Likes', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'tci-uet' ),
				'label_off' => __( 'Hide', 'tci-uet' ),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'     => __( 'Comments', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'tci-uet' ),
				'label_off' => __( 'Hide', 'tci-uet' ),
				'default'   => 'yes',
			]
		);

		$this->end_controls_section();


	}


	private function instagram_feed_for_elementor_feeds( $access_token, $image_num, $image_resolution ) {
		$url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . trim( $access_token ) . '&count=' . trim( $image_num );

		$feeds_json = wp_remote_fopen( $url );

		$feeds_obj = json_decode( $feeds_json, true );

		$feeds_images_array = array();

		if ( 200 == $feeds_obj['meta']['code'] ) {

			if ( ! empty( $feeds_obj['data'] ) ) {

				foreach ( $feeds_obj['data'] as $data ) {
					array_push( $feeds_images_array, array(
						$data['images'][ $image_resolution ]['url'],
						$data['link'],
						$data['likes'],
						$data['comments'],
						$data['type'],
					) );
				}

				$ending_array = array(
					'images' => $feeds_images_array,
				);

				return $ending_array;
			}
		}
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
		$id       = 'bdt-instagram-' . $this->get_id();
		?>
		<div class="wpcap-feed-main">
			<div class="wpcap-feed-inner">
				<?php
				$access_token     = $settings['access_token'];
				$number_of_images = $settings['number_of_images'];
				$image_size       = $settings['image_size'];
				$show_likes       = $settings['show_likes'];
				$show_comments    = $settings['show_comments'];
				$insta_feeds      = $this->instagram_feed_for_elementor_feeds( esc_html( $access_token ), absint( $number_of_images ), esc_html( $image_size ) );
				$count            = count( $insta_feeds['images'] );
				?>
				<div class="wpcap-feed-items wpcap-grid-container elementor-grid">
					<?php
					for ( $i = 0; $i < $count; $i ++ ) {
						if ( $insta_feeds['images'][ $i ] ) { ?>
							<div class="wpcap-feed-item feed-type-<?php echo esc_attr( $insta_feeds['images'][ $i ][4] ); ?>">
								<a href="<?php echo esc_url( $insta_feeds['images'][ $i ][1] ); ?>" target="_blank">
									<img src="<?php echo esc_url( $insta_feeds['images'][ $i ][0] ); ?>" alt="">
									<?php if ( 'yes' === $show_likes || 'yes' === $show_comments ) { ?>
										<div class="wpcap-feed-likes-comments">
											<?php if ( 'yes' === $show_likes ) { ?>
												<span class="wpcap-feed-likes"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php echo absint( $insta_feeds['images'][ $i ][2]['count'] ); ?></span>
											<?php } ?>
											<?php if ( 'yes' === $show_comments ) { ?>
												<span class="wpcap-feed-comments"><i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo absint( $insta_feeds['images'][ $i ][3]['count'] ); ?></span>
											<?php } ?>
										</div>
									<?php } ?>
								</a>
							</div>
							<?php
						}
					} ?>
				</div>
			</div>
		</div>
		<?php
	}
}
