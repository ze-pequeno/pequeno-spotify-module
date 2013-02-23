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

// set class namespace
namespace PequenoSpotifyModuleTest\Utils;

// set used namespaces
use Zend\ServiceManager\ServiceManager,
	Zend\Mvc\Service\ServiceManagerConfig;

class ServiceManagerFactory
{
	/** @var array */
	protected static $config;

	/** @var ServiceManager */
	protected static $serviceManager;

	/**
	 * Set ServiceManager configuration
	 * @access public
	 * @param array $config
	 * @return void
	 */
	public static function setConfig(array $config)
	{
		// store configuration
		static::$config = $config;
	}

	/**
	 * Builds a new service manager
	 * @access public
	 * @static
	 * @return ServiceManager
	 */
	public static function getServiceManager()
	{
		// check if ServiceManager instance exist
		if (self::$serviceManager === null) {

			// get service manager configuration
			$smConfig = isset(static::$config['service_manager']) ? static::$config['service_manager'] : array();

			// create ServiceManager from ServiceManagerConfig
			self::$serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));

			// set ApplicationConfig and ServiceListener to ServiceManager
			self::$serviceManager->setService('ApplicationConfig', static::$config);
			self::$serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

			/** @var $moduleManager \Zend\ModuleManager\ModuleManager */
			$moduleManager = self::$serviceManager->get('ModuleManager');

			// load module and ServiceManager
			$moduleManager->loadModules();
		}

		// return ServiceManager instance
		return self::$serviceManager;
	}

}