<?php
   if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// integrating cmb2 metaboxes in post type
add_action('cmb2_admin_init', 'clp_custom_metaboxes');

	/** creating settings panel using CMB2**/
	
	function clp_custom_metaboxes() {
	/**For custion coin settings**/
	
	/**
     * Initiate the metabox
     */


    $cmbdes = new_cmb2_box( array(
        'id'            => 'clp_coin_launcher',
        'title'         => __( 'Coin Details', 'clp1' ),
        'object_types'  => array( 'clp_coin_launcher'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
   
	) );	

	$cmbdes->add_field( array(
		'name'    => 'Upload Logo',
		'id'      => 'clp_test_image',
		'type'    => 'file',
		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Upload Logo' // Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		'query_args' => array(
		
			'type' => array(
			    'image/gif',
			    'image/jpeg',
			    'image/png',
			),
		),
		'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
	) );

		    $cmbdes->add_field( array(
		        'name' => __( 'Coin Name*', 'clp1' ),
		        'id' =>'clp_coin_name',
		        'type' => 'text',
				'attributes' => array(
					'required' => true, 
				) ,   
				'column' => array(
				'position' => 2,
			),
		    ) );
		
		    $cmbdes->add_field( array(
		        'name' => __( 'Coin Symbol*', 'clp1' ),
		        'id' =>'clp_coin_symbol',
		        'type' => 'text',
				'attributes' => array(
					'required' => true, 
				)    
		    ) );

			$cmbdes->add_field( array(
				'name' => 'Lanuch Date',
				'id'   => 'clp_coin_datetime_timestamp',
				'type' => 'text_datetime_timestamp',
				'attributes' => array(
					'required' => true, 
				)   
			) );
		
		    // $cmbdes->add_field( array(
		    // 	'name' => __('Network/Chain', 'clp1'),
			// 	'id' => 'clp_coin_chain',
			// 	'type' => 'select',
			// 	'options' => clp_supported_chains(),
			// 'default' => 'binance-smart-chain',
		    // 	) );

				
				$cmbdes->add_field( array(
					'name' => __('Project in presale phase?', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_presale',
					'default' => 'No',
					'type' => 'radio',
					'options' => array(
						'Yes' => __('Yes', 'clp1'),
						'No' => __('No', 'clp1'),
						
					),
				));
				$cmbdes->add_field( array(
					'name' => __( 'Contract Address*', 'clp1' ),
					'id' =>'clp_contract_address',
					'type' => 'text',
					'attributes' => array(
						'required' => true, 
						'data-conditional-id'    =>'clp_coin_presale',
						'data-conditional-value' =>json_encode(array("No")),
					)   
				) );	
				$cmbdes->add_field( array(
					'name' => __( 'Contract Address(optional)', 'clp1' ),
					'id' =>'clp_contract_address_optional',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coin_presale',
						'data-conditional-value' =>json_encode(array("Yes")),
					)   
				) );	
				
				$cmbdes->add_field( array(
					'name' => __( 'Presale Link(Optional)', 'clp1' ),
					'id'   => 'clp_presale_url',
					'type' => 'text_url',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coin_presale',
						'data-conditional-value' =>json_encode(array("Yes")),
					)   
				) );
			$cmbdes->add_field(array(
				'name' => __('Charts & Prices', 'clp1'),
				'desc' => '',
				'id' => 'clp_custom_price_link',
				'type' => 'pw_multiselect',
				'default' => '',
				'options' =>array(
					'poo_coin'=>"PooCoin",
					'coin_brain'=>"CoinBrain",
					'bogged_finance'=>"BoggedFinance",
					'gecko_terminal'=>"GeckoTerminal"
				), 
			));
			$cmbdes->add_field(array(
				'name' => __('Swap Links', 'clp1'),
				'desc' => '',
				'id' => 'clp_custom_swap_link',
				'type' => 'pw_multiselect',
				'default' => '',
				'options' =>array(
					'pancake_swap'=>"PancakeSwap",
					'flooz_trade'=>"Flooz.Trade",
				), 
			));
				$cmbdes->add_field( array(
					'name' => __( 'Affiliat/Buy Link ', 'clp1' ),
					'id' =>'clp_buy_sell_link',
					'type' => 'text',
					'desc' => 'Add custom affiliat link for this coin',
					 
					
				) );		
			$cmbdes->add_field( array(
				'name' => __( 'Show Coinbrain Chart', 'clp1' ),
				'desc' => 'Enable this option only if coin listed on coin brain',
				'id'   => 'clp_coinbrain_chart',
				'type' => 'checkbox',
				'default' => false
			) );
		    $cmbdes->add_field( array(		
				'id' => 'clp_coin_votes_today',
				'type' => 'hidden',
				'default'=> 0
			));
		    $cmbdes->add_field( array(
				'id' => 'clp_coin_votes_total',
				'type' => 'hidden',
				'default'=> 0
			));
		    $cmbdes->add_field( array(
				'id' => 'clp_watchlist_total',
				'type' => 'hidden',
				'default'=> 0
			));

			$cmbdes->add_field( array(
				'name' => __( 'Website URL', 'clp1' ),
				'id'   => 'clp_website_url',
				'type' => 'text_url',
				// 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
			) );
			$cmbdes->add_field( array(
				'name' => __( 'Twitter URL', 'clp1' ),
				'id'   => 'clp_twitter_url',
				'type' => 'text_url'
			) );
			$cmbdes->add_field( array(
				'name' => __( 'Telegram URL', 'clp1' ),
				'id'   => 'clp_telegram_url',
				'type' => 'text_url',	
				// 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
			) );
			$cmbdes->add_field( array(
				'name' => __( 'Discord URL', 'clp1' ),
				'id'   => 'clp_discord_url',
				'type' => 'text_url',	
				// 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
			) );

			$cmbdes->add_field( array(
				'name' => __('Coin listed on coingecko','cmc2' ),
				'id'   => 'clp_coingecko_listed',
				'type' => 'radio',
				'default'=>"no",
				'options' => array(
					'yes' => 'Yes',
					'no' => 'No',
				),
				) );
			$cmbdes->add_field( array(
				'name' => __('Coin Id*','cmc2' ),
				'id'   => 'clp_coin_id',
				'type' => 'text',
				'desc'=>'Like:- <strong>bitcoin</strong>',
				'attributes' => array(
					'required' => true,        
					'data-conditional-id'    =>'clp_coingecko_listed',
					'data-conditional-value' =>json_encode(array("yes")),
				  )
				) );

				$cmbdes->add_field( array(
					'name' => __('Price', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_price',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coingecko_listed',
						'data-conditional-value' =>json_encode(array("no")),        
					  )
				));
				$cmbdes->add_field( array(
					'name' => __('Market Cap', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_marketcap',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coingecko_listed',
						'data-conditional-value' =>json_encode(array("no")),
					  )
				));
				$cmbdes->add_field( array(
					'name' => __('Changes 24H ', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_changes',
					'type' => 'text',
					'attributes' => array(   
						'data-conditional-id'    =>'clp_coingecko_listed',
						'data-conditional-value' =>json_encode(array("no")),
					  )
				));

				$cmbdes->add_field(array(
					'name' => __('KYC Verfied', 'clp1'),
					'desc' => __('Select if KYC verified ?', 'clp1'),
					'id' => 'clp_coin_kfc_verfied',
					'type' => 'radio',
					'default'=>"no",
					'options' => array(
						'yes' => 'Yes',
						'no' => 'No',
					),
					
				));
				$cmbdes->add_field( array(
					'name' => __('KYC Verifyer Name', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_kfc_verfyer_name',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coin_kfc_verfied',
						'data-conditional-value' =>json_encode(array("yes")),
					),
					'default'=>"CoinSniper",
				));
				$cmbdes->add_field( array(
					'name' => __('KYC Verifyer Url', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_kfc_verfyer_url',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coin_kfc_verfied',
						'data-conditional-value' =>json_encode(array("yes")),
					),
					'default'=>get_site_url(),
				));
				$cmbdes->add_field(array(
					'name' => __('Audit', 'clp1'),
					'desc' => __('Select if Audit ?', 'clp1'),
					'id' => 'clp_coin_audit',
					'type' => 'radio',
					'default'=>"no",
					'options' => array(
						'yes' => 'Yes',
						'no' => 'No',
					),
				));
				$cmbdes->add_field( array(
					'name' => __('Auditer Name', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_auditer_name',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coin_audit',
						'data-conditional-value' =>json_encode(array("yes")),
					),
					'default'=>"Certik",
				));
				$cmbdes->add_field( array(
					'name' => __('Auditer Url', 'clp1'),
					'desc' => '',
					'id' => 'clp_coin_auditer_url',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    =>'clp_coin_audit',
						'data-conditional-value' =>json_encode(array("yes")),
					),
					'default'=>get_site_url(),
				));

				$cmbdes->add_field(array(
					'name' => __('Coin Description', 'clp1'),
					'id' =>'clp_coin_descritpion',
					'type' => 'wysiwyg',
					'sanitization_cb' => false,
					'desc' => '',
					//'media_buttons' =>false,
));
		}