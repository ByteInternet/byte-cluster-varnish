<?php
/**
 * @author Ferdy Perdaan
 * @version 1.0
 *
 * Abstract cache class
 */

abstract class XLII_Cache_Instance extends XLII_Cache_Singleton
{
	/**
	 * Delete the page cache.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @return	bool
	 */ 
	public function delete($key)
	{
		set_time_limit(0);
		
		return $this->isValid() ? $this->_delete(array_map(array($this, '_key'), (array)$key)) : false;
	}
	
	/**
	 * Delete the page cache, inner helper method of @see delete.
	 * 
	 * @param	array $key The key the cache attribute is referred by.
	 * @return	bool
	 */ 
	abstract protected function _delete(array $key);
	
	
	/**
	 * Flush the entire cache.
	 *
	 * When WPML is activated, all WPML domains are gathered and flushed one by one
	 * 
	 * @return	bool
	 */ 
	public function flush()
	{
		// Get all WPML domains
		if ( function_exists('icl_object_id') ) {
			$success = false;
			foreach(icl_get_languages() as $lang) {
				$success = ($this->delete($lang['url'] . '/.*') && $success ? true : false);
			}
			return $success;
		}
		else {
			return $this->delete(home_url('/.*'));
		}
	}
	
	/**
	 * Returns wether this page exists within the cache.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @return	bool|null
	 */ 
	public function exists($key)
	{
		return $this->isValid() ? $this->_exists($this->_key($key)) : false;
	}
	
	/**
	 * Returns wether this page exists within the cache, inner helper method of @see exists.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @return	bool|null
	 */ 
	protected function _exists($key)
	{
		global $wpdb;
		
		if(isset($wpdb->cache_log))
			return $wpdb->get_var($wpdb->prepare('SELECT COUNT(1) FROM ' . $wpdb->cache_log . ' WHERE url = %s', $key)) > 0;
		else
			return null;
	}
	
	/**
	 * Return the cache object referred by the given key.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @return	void|false
	 */ 
	public function get($key)
	{
		return $this->isValid() ? $this->_get($this->_key($key)) : false;
	}
	
	/**
	 * Return the cache object referred by the given key, inner helper method of @see get.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @return	void|false
	 */ 
	abstract protected function _get($key);
	
	/**
	 * Mutate the key to a generic key.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @return	string
	 */
	protected function _key($key)
	{
		return str_replace('https', 'http', $key);
	}
	
	/**
	 * Returns wether the cache connection is valid
	 * 
	 * @return	bool
	 */
	abstract public function isValid();
	
	/**
	 * Store cache data under the given key.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @param	void $value The value to store within the cache.
	 * @return	bool
	 */ 
	public function set($key, $value)
	{
		return $this->isValid() ? $this->_set($this->_key($key), $value) : false;
	}
	
	/**
	 * Store cache data under the given key, inner helper method of @see set.
	 * 
	 * @param	string $key The key the cache attribute is referred by.
	 * @param	void $value The value to store within the cache.
	 * @return	bool
	 */ 
	abstract protected function _set($key, $value);
}
