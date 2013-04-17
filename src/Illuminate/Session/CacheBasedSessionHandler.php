<?php namespace Illuminate\Session;

use Illuminate\Cache\Repository;

class CacheBasedSessionHandler implements \SessionHandlerInterface {

	/**
	 * @var \Memcached Memcached driver.
	 */
	protected $cache;

	/**
	 * The number of minutes to store the data in the cache.
	 *
	 * @var int
	 */
	protected $minutes;

	/**
	 * Create a new cache driven handler instance.
	 *
	 * @param  Illuminate\Cache\Repository  $cache
	 * @param  int  $minutes
	 * @return void
	 */
	public function __construct(Repository $cache, $minutes)
	{
		$this->cache = $cache;
		$this->minutes = $minutes;
	}

	/**
	 * {@inheritDoc}
	 */
	public function open($savePath, $sessionName)
	{
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function close()
	{
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function read($sessionId)
	{
		return $this->cache->get($sessionId) ?: '';
	}

	/**
	 * {@inheritDoc}
	 */
	public function write($sessionId, $data)
	{
		return $this->cache->put($sessionId, $data, $this->minutes);
	}

	/**
	 * {@inheritDoc}
	 */
	public function destroy($sessionId)
	{
		return $this->cache->forget($sessionId);
	}

	/**
	 * {@inheritDoc}
	 */
	public function gc($lifetime)
	{
		return true;
	}

}