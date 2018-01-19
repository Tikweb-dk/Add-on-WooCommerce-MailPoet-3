<?php
/**
 * Checkout page field
 * @since      1.0.0
 * @package    Add-on WooCommerce MailPoet 3
 * @subpackage add-on-woocommerce-mailpoet/includes
 * @author     Tikweb <kasper@tikjob.dk>
 */

use MailPoet\Models\Segment;
use MailPoet\Models\Subscriber;

if(!class_exists('MPWA_Frontend_Fields')){
	class MPWA_Frontend_Fields
	{
		//Helper trait
		use MPWA_Helper_Function;

		//Properties
		public $form_position;
		public $show_form;
		public $default_status;
		public $list_ids;

		/**
		 * Initialize the class
		 */
		public static function init()
		{
			$_this_class = new self;
			return $_this_class;
		}//Edn of init

		/**
		 * Constructor
		 */
		public function __construct()
		{
			//Check for if user logged in and already subscribed
			if(is_user_logged_in()){

				$current_user = wp_get_current_user();
				$user_subscriber = Subscriber::whereEqual('email', $current_user->user_email)->whereEqual('status', 'subscribed')->findArray();
				
				//If logged in user is not mailpoet subscriber
				if(empty($user_subscriber)){
					$this->run_actions();
				}
			}else{
				$this->run_actions();
			}//End if
		}//End of __construct

		/**
		 * Run necessary hooks
		 * Show subscribe form
		 */
		public function run_actions()
		{
			//Get the form showing position
			$this->form_position = get_option('wc_'.$this->tab_slug.'_subscription_position');

			//Enable show subscription form
			$this->show_form = get_option('wc_'.$this->tab_slug.'_enable_subscription');

			//Get default checkbox status
			$this->default_status = get_option('wc_'.$this->tab_slug.'_checkbox_status');

			//Get default checkbox status
			$this->multi_subscription = get_option('wc_'.$this->tab_slug.'_multi_subscription');

			//Subscription Lists selected
			$this->list_ids = get_option('wc_mailpoet_segment_list'); 

			//If tick the `Enable subscription` checkbox
			if('yes' == $this->show_form){
				//Hook into the checkout page. Adds the subscription fields.
				add_action('woocommerce_'.$this->form_position, array($this, 'checkout_page_form'));
			}
		}//End of run_actions

		/**
		 * Checkout page form
		 */
		public function checkout_page_form()
		{
			?>
			<div class="mailpoet-subscription-section">
				<h3><?php $this->_e('Subscribe to Newsletter/s'); ?></h3>
				<?php if('yes' == $this->multi_subscription): ?>
					<?php
						$sagments = Segment::whereIdIn($this->list_ids)->findArray();
						if(is_array($sagments)): foreach($sagments as $sagment):
					?>
					<p class="form-row form-row-wide mailpoet-subscription-field" id="mailpoet-list-<?php echo $sagment['id']; ?>">
						<label>
							<input class="input-checkbox" name="mailpoet_multi_subscription[]" value="<?php echo $sagment['id']; ?>" type="checkbox" <?php checked($this->default_status, 'checked'); ?> > 
							<?php echo $sagment['name']; ?>
						</label>
					</p>
					<?php endforeach; endif; ?>
				<?php else: ?>
					<?php
						// Subscribe Checkbox Label
						$checkout_label = get_option('wc_'.$this->tab_slug.'_checkout_label'); 
						// Puts default label if not set in the settings.
						$subscribe_label = !empty($checkout_label) ? $checkout_label : $this->__('Yes, please subscribe me to the newsletter/s.');
					?>
					<p class="form-row form-row-wide mailpoet-subscription-field">
						<label>
							<input class="input-checkbox" name="mailpoet_checkout_subscribe" value="1" type="checkbox" <?php checked($this->default_status, 'checked'); ?> > 
							<?php echo $subscribe_label; ?>
						</label>
					</p>
				<?php endif; ?>
			</div>
			<?php
		}//End of checkout_page_form

	}//End of class

	/**
	 * Instentiate class after posts selection
	 */
	function mpwa_frontend_fields_init_posts_selection(){
		if(is_checkout()){
			MPWA_Frontend_Fields::init();
		}
	}
	add_action('posts_selection', 'mpwa_frontend_fields_init_posts_selection');
}//End if