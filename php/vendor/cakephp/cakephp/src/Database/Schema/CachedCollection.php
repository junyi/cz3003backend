<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Database\Schema;

use Cake\Cache\Cache;
use Cake\Database\Connection;
use Cake\Database\Schema\Collection;

/**
 * Extends the schema collection class to provide caching
 *
 */
class CachedCollection extends Collection
{

    /**
     * The name of the cache config key to use for caching table metadata,
     * of false if disabled.
     *
     * @var string|bool
     */
    protected $_cache = false;

    /**
     * Constructor.
     *
     * @param \Cake\Database\Connection $connection The connection instance.
     * @param string|bool $cacheKey The cache key or boolean false to disable caching.
     */
    public function __construct(Connection $connection, $cacheKey = true)
    {
        parent::__construct($connection);
        $this->cacheMetadata($cacheKey);
    }

    /**
     * {@inheritDoc}
     *
     */
    public function describe($name, array $options = [])
    {
        $options += ['forceRefresh' => false];
        $cacheConfig = $this->cacheMetadata();
        $cacheKey = $this->cacheKey($name);

        if (!empty($cacheConfig) && !$options['forceRefresh']) {
            $cached = Cache::read($cacheKey, $cacheConfig);
            if ($cached !== false) {
                return $cached;
            }
        }

        $table = parent::describe($name, $options);

        if (!empty($cacheConfig)) {
            Cache::write($cacheKey, $table, $cacheConfig);
        }

        return $table;
    }

    /**
     * Get the cache key for a given name.
     *
     * @param string $name The name to get a cache key for.
     * @return string The cache key.
     */
    public function cacheKey($name)
    {
        return $this->_connection->configName() . '_' . $name;
    }

    /**
     * Sets the cache config name to use for caching table metadata, or
     * disables it if false is passed.
     * If called with no arguments it returns the current configuration name.
     *
     * @param bool $enable whether or not to enable caching
     * @return string|bool
     */
    public function cacheMetadata($enable = null)
    {
        if ($enable === null) {
            return $this->_cache;
        }
        if ($enable === true) {
            $enable = '_cake_model_';
        }
        return $this->_cache = $enable;
    }
}
