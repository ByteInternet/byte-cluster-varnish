<?php
/**
 * @author Ferdy Perdaan
 * @version 1.0
 *
 * Abstract cache class
 */

abstract class XLII_Cache
{
	static private $_instance;
	static private $_queue;
	static private $_flush;
	
	/**
	 * Generic static methods used as calltrough
	 * 
	 * @param	string $method The method to call on the cache object.
	 * @param	array $arguments An array containing arguments passed to the cache object.
	 * @return	void
	 */
	static public function __callStatic($method, $arguments)
	{
		$obj = self::getInstance();
		
		return call_user_func_array(array($obj, $method), $arguments);
	}
	
	/**
	 * Delete the page cache.
	 * 
	 * @param	string|array $key The key the cache attribute is referred by.
	 * @return	bool
	 */ 
	static public function delete($key)
	{
		if(self::$_flush)
			return self::getInstance()->delete($key);
			
		if(self::$_queue !== true)
		{
			if(is_array($key))
				self::$_queue = array_merge(self::$_queue, $key);
			else
				self::$_queue[] = $key;
				
			if(($max = XLII_Cache_Manager::option('general.flushing')) && $max > 0)
			{
				if(count(self::$_queue) >= $max)
					self::$_queue = true;
			}
		}
		
		return true;
	}
	
	/**
	 * Flush the entire cache.
	 * 
	 * @return	bool
	 */ 
	static public function flush()
	{
		if(self::$_flush)
			return self::getInstance()->flush();
		
		self::$_queue = true;
		
		return true;
	}
	
	/**
	 * Called upon destructing the class, flush all registered urls
	 * 
	 * @return	bool
	 */
	static public function flushQueue()
	{
		if(!($flush = self::getQueue()) || !$obj = self::getInstance())
			return true;
		
		self::$_queue = array();	
		
		if($flush === true)
			return $obj->flush();
		
		else 
			return $obj->delete($flush);
	}
	
	/**
	 * Return the active cache manager instance.
	 * 
	 * @return	XLII_Cache_Instance	
	 */
	static public function getInstance()
	{
		// for now always use varnish
		if(self::$_instance === null)
			self::$_instance = XLII_Cache_Varnish::getInstance();
		
		return self::$_instance;
	}
	
	/**
	 * Return the generated queue.
	 * 
	 * @return	array|true
	 */
	static public function getQueue()
	{
		return self::$_queue === true ? true : array_unique(self::$_queue);
	}

	/**
	 * Initialize the cache manager
	 * 
	 * @access	private
	 */
	static public function init()
	{
		self::$_queue = array();
		self::$_flush = defined('CACHE_QUEUE') && !CACHE_QUEUE;
		
		register_shutdown_function(array(__CLASS__, 'flushQueue'));
	}
}