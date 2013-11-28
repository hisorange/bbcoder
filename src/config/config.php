<?php
return array(
	// Loaded config's path.
	'cpath'	=> __DIR__,
	
	// Detailed explanations @ http://milesj.me/code/php/decoda
	'profile' => array(
		'default'		=> array(
			// Parser configurations.
			'parser'	=> array(
				'open' => '[',
				'close' => ']',
				'locale' => 'hu-hu',
				'disabled' => false,
				'shorthandLinks' => false,
				'xhtmlOutput' => false,
				'escapeHtml' => true,
				'strictMode' => true,
				'maxNewlines' => 3,
				'lineBreaks' => true,
				'removeEmpty' => false
			),

			// Hooks being loaded as default.
			'hooks'		=> array(
				'Decoda\Hook\CensorHook' => array(),
				'Decoda\Hook\ClickableHook' => array(),
				'Decoda\Hook\CodeHook' => array(),
				'Decoda\Hook\EmoticonHook' => array('path' => '/assets/imgs/emoticons/', 'extension' => 'png'),
			),

			// Filters being loaded as default.
			'filters'	=> array(
				'Decoda\Filter\BlockFilter',
				'Decoda\Filter\CodeFilter',
				'Decoda\Filter\DefaultFilter',
				'Decoda\Filter\EmailFilter',
				'Decoda\Filter\ImageFilter',
				'Decoda\Filter\ListFilter',
				'Decoda\Filter\QuoteFilter',
				'Decoda\Filter\TableFilter',
				'Decoda\Filter\TextFilter',
				'Decoda\Filter\UrlFilter',
				'Decoda\Filter\VideoFilter',
			),

			// To only parse specific tags, pass an array of whitelisted tags.
			'whitelist' => array('b', 'u', 'i', 'br', 'hr', 'img', 'youtube'),

			// To not parse specific tags, pass an array of blacklisted tags.
			'blacklist' => array(),
		),
		
		// Example profile.
		'comments'	=> array(
			'whitelist' => array('i', 'b', 'u'),
		),
	)

	
);
