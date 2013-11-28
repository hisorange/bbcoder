## Laravel 4 BBCoder

Adding the well developed Decoda repository to Laravel 4, with a small modification.
The repository contains the basic functionality of the Decoda, but extends with configuration profiles.

###### Check it out how to use:


```php
// Simply convert the string with the default profile.
echo BBCoder::convert('This is an [b]example[/b]! But [i]this[/i] is just the beggining...');

// Conver the string with a differnt profile initialized.
echo BBCoder::convert('In the forum [quote]quote[/quote] tags are allowed.', 'forum');
```

###### Creating a profile:
```php
// config/packages/hisorange/bbcoder/profile/comments
<?php
return array(
    // Under the 'comments' profile only the <u> <i> <b> html tags will be allowed.
    'whitelist' => array('u', 'i', 'b'),
    
    // You can overwrite which filters being loaded.
    'filters'	=> array(
		'Decoda\Filter\DefaultFilter',
		'Decoda\Filter\TextFilter',
    ),
);
```

When you create a new profile config be cautious becaues the configurations do not merge recursive.
This means when you create a profile e.g.: pageedit

###### Wrong way:
```php
    // This will overwride the default config's 'parser' value but will remove the other keys.
   'parser' => array(
        'open' => '{',
	    'close' => '}',
   ),
```

###### Right way:
```php
   'parser'	=> array(
		'open' => '{',
		'close' => '}',
		'locale' => 'en-us',
		'disabled' => false,
		'shorthandLinks' => false,
		'xhtmlOutput' => false,
		'escapeHtml' => true,
		'strictMode' => true,
		'maxNewlines' => 3,
		'lineBreaks' => true,
	    'removeEmpty' => false
    ),
```

This is necessary in case where you would add the 'b' tag to the white list only, but if the default allows the 'quote' tag then the array_merge could result an array('b', 'quote') while you only wanted to allow the 'b' tags.

The profiles inherits the default config.php values.

###### Extra configuration files
In the config directory can find the censored.php, emoticons.php, messages.php those work exactly as the Decoda describe it, but I added a fallback loading so the FileLoader will look into the active profile's directory first and if cannot find the config will use the default. At this way you can use different emotions for different purposes.

###### Reset / use default configuration.
```php

// Use the forum profile for the converting.
echo BBCoder::convert('[spolier]Do not show me, I am naked![/abbr]', 'forum');

// To reset back to the original profile simply use the null.
// But if the null is not passed the script will use the last used profiled 'forum' in this case.
echo BBCoder::convert('[spolier]Do not show me, I am naked![/abbr]', null);
```

###### Work with the Decoda\Decoda object.
If you need to interact with the original class simply call it on the BBCoder.

```php
BBCoder::getHook('Emoticon');
```

### Installation / Composer

Add to following line to your composer.json

```json
"require": {
    "hisorange/bbcoder": "dev-master"
}
```

Add the ServiceProvider to your app.php in the config directory 

```php
'providers' => array(
    // .. other providers ..
    'hisorange\bbcoder\Providers\BBCoderServiceProvider',
)
```

Run composer update ;) The package will automaticaly registers the BBCoder alias to your application.

For further informations about the BB Code parser configurations check out the [milesj/decoda](https://github.com/milesj/decoda) repo <3
