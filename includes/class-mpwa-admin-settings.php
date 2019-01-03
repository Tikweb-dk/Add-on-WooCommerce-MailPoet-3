<?php
/**
 * Plugin admin settings class.
 * @since      1.0.0
 * @package    Add-on WooCommerce MailPoet 3
 * @subpackage add-on-woocommerce-mailpoet/includes
 * @author     Tikweb <kasper@tikjob.dk>
 */

use MailPoet\Models\Segment;

if(!class_exists('MPWA_Admin_Settings')){
	class MPWA_Admin_Settings extends WC_Settings_Page 
	{
		//Helper trait
		use MPWA_Helper_Function;

		/**
		 * Initialize the class
		 */
		public static function init()
		{
			$_this_class = new self;
			return $_this_class;
		}

		/**
		 * Constructor
		 */
		public function __construct()
		{
			//Pre-defined properties
			$this->id    = $this->tab_slug;
			$this->label = $this->__('MailPoet');

			//Add mailpoet settings tab
			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );

			//Sections tab
			add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );

			//Settings tab output page content
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );

			//Save form data
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );

		}//End of __construct

		/**
		 * Define sections tab for MailPoet tab
		 */
		public function get_sections() 
		{
			return array(
				''      => $this->__('General'),
				'lists' => $this->__('Available Lists')
			);
		}

		/**
		 * Define all settings field
		 */
		public function get_settings($current_section = '') 
		{
			if('lists' == $current_section){ //For Available Lists tab

				//Available Lists settings fields
				return array(
					array(
						'title' => $this->__('Available Lists'),
						'type'  => 'title',
						'desc'  => $this->__('Simply tick the lists you want your customers to subscribe to or allow the customer to choose from and press "Save changes".'),
						'id'    => 'wc_'.$this->id.'_lists_options_title'
					),
					array(
						'type' => 'sectionend',
						'id'   => 'wc_'.$this->id.'_lists_options_end'
					)
				); // End lists settings

			}else{ //For General tab

				//General settings fields
				return array(
		            array(
		                'name'     => $this->__('MailPoet WooCommerce Add-on'),
		                'type'     => 'title',
		                'desc'     => $this->__('Now your customers can subscribe to newsletters you have created with MailPoet as they order. These settings control how your customers subscribe.'),
		                'id'       => 'wc_'.$this->id.'_general_section_title'
		            ),
		            array(
		                'name'     => $this->__('Enable subscription?'),
						'desc'     => $this->__('Tick this box to enable MailPoet subscription during checkout.'),
						'id'       => 'wc_'.$this->id.'_enable_subscription',
						'type'     => 'checkbox',
						'default'  => 'yes'
		            ),
		            array(
		                'title'    => $this->__('Multi-Subscription?'),
						'desc'     => sprintf( 
							$this->__('If you have more than one newsletter. Allow your customers to select which lists they wish to subscribe too. %s %s'), 
							'<a class="button button-primary" href="'.admin_url('admin.php?page=mailpoet-segments').'" target="_blank">Edit Lists</a>', 
							'<a class="button" href="'.admin_url('admin.php?page=wc-settings&tab='.$this->id.'&section=lists').'">Available Lists</a>' 
						),
						'id'       => 'wc_'.$this->id.'_multi_subscription',
						'default'  => 'no',
						'type'     => 'select',
						'class'	   => 'wc-enhanced-select',
						'options'  => array(
							'no'  => $this->__('No'),
							'yes' => $this->__('Yes')
						)
		            ),
		            array(
						'name'     => $this->__('Enable Double Opt-in?'),
						'desc'     => $this->__('Controls whether a double opt-in confirmation message is sent, defaults to true.'),
						'id'       => 'wc_'.$this->id.'_double_optin',
						'type'     => 'checkbox',
						'default'  => 'yes'
					),
					array(
						'name'     => $this->__('Default checkbox status'),
						'desc'     => $this->__('The default state of the subscribe checkbox. Be aware some countries have laws against using opt-out checkboxes.'),
						'desc_tip' => true,
						'id'       => 'wc_'.$this->id.'_checkbox_status',
						'class'    => 'single_list_only wc-enhanced-select',
						'default'  => 'unchecked',
						'type'     => 'select',
						'options'  => array(
							'checked'   => $this->__('Checked'),
							'unchecked' => $this->__('Un-checked')
						)
					),
					array(
						'name'        => $this->__('Subscribe checkbox label'),
						'desc'        => $this->__('The text you want to display next to the "Subscribe to Newsletter" checkbox.'),
						'id'          => 'wc_'.$this->id.'_checkout_label',
						'css'         => 'min-width:350px;',
						'type'        => 'text',
						'placeholder' => $this->__('Yes, please subscribe me to the newsletter.'),
						'class'       => 'single_list_only'
					),
					array(
						'name'     => $this->__('Subscription Position'),
						'desc'     => $this->__('Select where on the checkout page you want to display the subscription sign-up.'),
						'desc_tip' => true,
						'id'       => 'wc_'.$this->id.'_subscription_position',
						'default'  => 'after_order_notes',
						'type'     => 'select',
						'class'	   => 'wc-enhanced-select',
						'options'  => apply_filters('mailpoet_woocommerce_subscription_position', array(
							'before_checkout_billing_form'  => $this->__('Before Billing Form'),
							'after_checkout_billing_form'   => $this->__('After Billing Form'),
							'before_checkout_shipping_form' => $this->__('Before Shipping Form'),
							'after_checkout_shipping_form'  => $this->__('After Shipping Form'),
							'before_order_notes'            => $this->__('Before Order Notes'),
							'after_order_notes'             => $this->__('After Order Notes'),
							'review_order_before_submit'     => $this->__('Before Order Submit'),
							'review_order_after_submit'     => $this->__('After Order Submit')
						))
					),
					array(
						'title'   => $this->__('Remove all data on uninstall?'),
						'desc'    => $this->__('If enabled, all settings for this plugin will all be deleted when uninstalling via Plugins > Delete.'),
						'id'      => 'wc_'.$this->id.'_uninstall_data',
						'default' => 'no',
						'type'    => 'checkbox'
					),
					array(
						'type'		=> 'sectionend'
					),
					array(
						'title'		=> $this->__('GDPR'),
						'type'		=> 'title',
					),
					array(
						'title'		=>	$this->__('Display GDPR Subscription consent Text?'),
						'desc'		=>	$this->__('Show GDPR Subscription Consent Text'),
						'id'		=> 'wc_'.$this->id.'_show_gdpr_consent',
						'default'	=> 'no',
						'type'		=> 'checkbox'
					),
					array(
						'title'    => $this->__('Privacy page'),
						'desc'     => $this->__('Choose a page to act as your privacy policy.'),
						'id'       => 'wp_page_for_privacy_policy',
						'type'     => 'single_select_page',
						'default'  => '',
						'class'    => 'wc-enhanced-select-nostd',
						'css'      => 'min-width:300px;',
						'desc_tip' => true,
					),
					array(
						'title'		=> $this->__('GDPR Subscription Consent Text'),
						'desc'		=> $this->__('<i>Write plain or HTML format and include <strong>[privacy_policy]</strong> shortcode to link privacy page in your text. </i>'),
						'type'		=> 'textarea',
						'id'		=> 'wc_'.$this->id.'_gdpr_subscription_consent_text',
						'default'	=> 'By subscribing you agree to receive our newsletter and agree with our [privacy_policy]. You may unsubscribe at any time.'
					),
					array(
						'title'		=> $this->__('Display Unsubscribe option'),
						'desc'		=>	$this->__('Let customer unsubscribe through checkbout page'),
						'type'		=> 'checkbox',
						'id'		=> 'wc_'.$this->id.'_gdpr_show_unsubscribe',
						'default'	=> 'no'
					),
					array(
						'title'		=> $this->__('Unsubscribe checkbox label'),
						'desc'		=> $this->__('If this feature is enabled, a checkbox will be display in checkout page after subscription section which will let your customer to unsubscribe from mailpoet.'),
						'desc_tip'	=> true,
						'type'		=> 'text',
						'id'		=> 'wc_'.$this->id.'_gdpr_unsubscribe_label',
						'default'	=> $this->__('Unsubscribe from our newsletter')
					),
		            array(
		                'type' => 'sectionend',
		                'id' => 'wc_'.$this->id.'_general_section_end'
		            )
		        );//End General tab fields
			}
	        
	    }//End of get_settings

	    /**
		 * Output the settings.
		 */
		public function output() 
		{
			global $current_section;
			$settings = $this->get_settings( $current_section );
			WC_Admin_Settings::output_fields( $settings );

			//Link script file to this page
			wp_enqueue_script('mailpoet_woocommerce_settings',  MPWA_ROOT_URL.'assets/js/settings.js', array(), time(), true);

			//Show list table for Available Lists tab
			if('lists' == $current_section){ 
				$this->mailpoet_segment_list();
			}
		}//End of output

		/**
		 * List table for `Available Lists` tab
		 */
		public function mailpoet_segment_list()
		{
			?>
			<style type="text/css">
				.wc-mailpoet-list-table tbody tr:nth-child(odd){background-color: #f3f2f2;}
				.wc-mailpoet-list-table.widefat td {padding: 13px 10px 15px;}
			</style>
			<table class="wc-mailpoet-list-table widefat">
				<thead>
					<tr>
						<th width="60"><?php $this->_e('Enabled'); ?></th>
						<th><?php $this->_e('Newsletters'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$list_ids = get_option('wc_mailpoet_segment_list');
						if(!is_array($list_ids)) $list_ids = array('');

						$sagments = Segment::where_not_equal('type', Segment::TYPE_WP_USERS)->findArray();
						if(is_array($sagments)): foreach($sagments as $sagment):

						$has_id = in_array($sagment['id'], $list_ids);
					?>
					<tr>
						<td>
							<input type="checkbox" 
								name="wc_mailpoet_segment_list[]" 
								value="<?php echo $sagment['id']; ?>" 
								id="list-<?php echo $sagment['id']; ?>" 
								<?php checked($has_id, true); ?> 
							/>
						</td>
						<td>
							<label for="list-<?php echo $sagment['id']; ?>"><?php echo $sagment['name']; ?></label>
						</td>
					</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>
			<?php
		}//End of mailpoet_segment_list


		/**
		 * Save settings.
		 */
		public function save() 
		{
			global $current_section;

			$settings = $this->get_settings( $current_section );
			WC_Admin_Settings::save_fields( $settings );

			//If current section is list then save list table data
			if($current_section == 'lists'){
				if( isset($_POST['wc_mailpoet_segment_list']) ){
					//if tick any checkbox
					update_option('wc_mailpoet_segment_list', $_POST['wc_mailpoet_segment_list']);
				}else{
					//If don't tick any checkbox 
					delete_option('wc_mailpoet_segment_list');
				}
			}
		}//End of save

	}//End of class

	/**
	 * Instentiate core class
	 */
	return MPWA_Admin_Settings::init();

}//End if
