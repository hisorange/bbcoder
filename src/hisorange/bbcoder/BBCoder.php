<?php
namespace hisorange\bbcoder;

use Decoda\Decoda;
use Illuminate\Config\Repository;

class BBCoder extends Decoda
{
	/**
	 * App configurations.
	 *
     * @type Illuminate\Config\Repository
	 */
	protected $_configs = array();

	/**
	 * Currently loaded profile.
	 *
	 * @type string
	 */
	protected $_profile = null;

	/**
	 * Set up Decoda.
	 *
     * @param array $config
	 */
	public function __construct(Repository $configs)
	{
		// Save the configurations.
		$this->_configs = $configs;

		// Initialize default configs.
		$this->setProfile(null);
	}

	/**
	 * Get the currently active profile's name.
	 *
	 * @return string
	 */
	public function getProfile()
	{
		return $this->_profile;
	}

	/**
	 * Change the active profile.
	 *
	 * @return \hisorange\bbcoder\BBCoder
	 */
	public function setProfile($profile)
	{
		$this->_profile = $profile;

		// Set the parser configs.
		$this->setConfig($this->getProfileConfig('parser'));
        $this->reset($this->_string, true);
        $this->defaults();

        return $this;
	}

	/**
	 * Load the profile's config.
	 *
	 * @return array
	 */
	public function getProfileConfig($key = 'config')
	{
		// If no profile setted load the config.php
		if (empty($this->_profile)) {
			return $this->_configs->get('bbcoder::'.$key);
		}

		// Check if the profile overwrites the default config.
		if ($this->_configs->has('bbcoder::profile/'.$this->_profile.'.'.$key)) {
			return $this->_configs->get('bbcoder::profile/'.$this->_profile.'.'.$key);
		}

		return $this->_configs->get('bbcoder::'.$key);
	}

	/**
	 * Set defaults for the profile.
	 *
	 * @return \hisorange\bbcoder\BBCoder
	 */
	public function defaults()
	{
		// Reset filters.
        foreach ($this->getProfileConfig('filters') as $filter) {
        	$this->addFilter(new $filter);
        }

        // Reset hooks.
        foreach ($this->getProfileConfig('hooks') as $hook => $config) {
        	$this->addHook(new $hook($config));
        }

        // Reset black & white list.
        $this->whitelist($this->getProfileConfig('whitelist'));
        $this->blacklist($this->getProfileConfig('blacklist'));

        $configNamespaces = $this->_configs->getNamespaces();

        // Add profile's path first the default acts as fallback.
        if (isset($this->_profile)) {	
       		$this->addPath($configNamespaces['bbcoder'].'/'.$this->_profile);
        }

        // Add default path.
        $this->addPath($configNamespaces['bbcoder']);

        return $this;
	}

	/**
	 * Convert BB Code string into formated (X)HTML.
	 *
	 * @return string
	 */
	public function convert($string, $profile = null)
	{
        $this->_chunks = array();
        $this->_nodes = array();
        $this->_parsed = '';
        $this->_stripped = '';
        $this->_string = $this->escape($string);

        // Change profile.
        if ($this->_profile !== $profile) {
        	$this->setProfile($profile);
        }
       
		return $this->parse();
	}
}