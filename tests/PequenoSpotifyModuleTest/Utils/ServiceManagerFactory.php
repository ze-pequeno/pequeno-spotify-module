<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

// set namespace
namespace PequenoSpotifyModuleTest\Utils;

// set used namespaces
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

class ServiceManagerFactory
{
    /** @var array */
    protected static $configuration;

    /** @var ServiceManager */
    protected static $serviceManager;

    /**
     * Initialize bootstrap class
     * @access public
     * @static
     * @return void
     */
    public static function bootstrap()
    {
        // init autoloader
        static::initAutoloader();

        // init configuration
        static::initConfiguration();
    }

    /**
     * Initialize class autoloader
     * @access protected
     * @static
     * @return void
     *
     * @throws RuntimeException
     */
    protected static function initAutoloader()
    {
        // get vendor path
        $vendorPath = static::findParentPath('vendor');

        // check if vendor autoload file not exists
        if (!$vendorPath || !file_exists($vendorPath.'/autoload.php')) {

            // throw RuntimeException indicate composer autoloader is not found
            throw new RuntimeException('vendor/autoload.php could not be found. Did you install via composer ?');
        }

        /** @noinspection PhpIncludeInspection include autoload file */
        $loader = include $vendorPath.'/autoload.php';

        // add PequenoSpotifyModuleTest to loader
        $loader->add('PequenoSpotifyModuleTest', dirname(dirname(__DIR__)));
    }

    /**
	 * Load configuration needed by tests
	 * @access protected
	 * @static
	 *
	 * @throws RuntimeException
	 */
    protected static function initConfiguration()
    {
        // get tests path
        $testsPath = static::findParentPath('tests');

        // include configuration file
        $files = array($testsPath.'/TestConfiguration.php', $testsPath.'/TestConfiguration.php.dist');
        foreach ($files as $file) {
            if (file_exists($file)) {
                /** @noinspection PhpIncludeInspection */
                static::$configuration = require $file;
                break;
            }
        }

        // throw if no valid configuration found
        if (static::$configuration === null)
            throw new RuntimeException(sprintf('no valid configuration file found : %s', implode(', ', $files)));
    }

    /**
	 * Get service manager instance
	 * @access public
	 * @static
	 * @return ServiceManager
	 */
    public static function getServiceManager()
    {
        // retrieve configuration
        $config = static::$configuration ?: array();

        // get service manager configuration
        $smConfig = isset($config['service_manager']) ? $config['service_manager'] : array();

        // create service manager instance
        $serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));

        // set application configuration to service manager
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');

        // load modules and return service manager instance
        $moduleManager->loadModules();

        // return service manager
        return $serviceManager;
    }

    /**
     * Find parent path
     * @access protected
     * @static
     * @param  string      $path Path to search
     * @return bool|string
     */
    protected static function findParentPath($path)
    {
        // setup current and previous directory
        $currentDir = __DIR__;
        $previousDir = '.';

        // iterate all previous directory
        while (!is_dir($currentDir.DIRECTORY_SEPARATOR.$path)) {

            // update current directory
            $currentDir = dirname($currentDir);

            // chech if current and previous directories are same
            if ($previousDir === $currentDir) {

                // return false
                return false;
            }

            // update previous directory
            $previousDir = $currentDir;
        }

        // return directory according path
        return $currentDir.DIRECTORY_SEPARATOR.$path;
    }
}
