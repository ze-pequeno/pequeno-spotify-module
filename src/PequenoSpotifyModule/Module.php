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
namespace PequenoSpotifyModule;

// set used namespaces
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        // return autoloader configuration
        return array(
            // classmap autoloader
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__.'/../../autoload_classmap.php',
            ),
            // standard autoloader
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/../../src/'.str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    /**
     * Get module configuration
     * @access public
     * @return array
     */
    public function getConfig()
    {
        // return module configuration
        return include __DIR__.'/../../config/module.config.all.php';
    }

    /**
     * Listener to the bootstrap event
     * @access public
     * @param  EventInterface $e
     * @return void
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var \Zend\Mvc\MvcEvent $e get application event manager instance */
        $eventManager = $e->getApplication()->getEventManager();

        // get ModuleRouteListener instance
        $moduleRouteListener = new ModuleRouteListener();

        // attach event manager to ModuleRouteListener
        $moduleRouteListener->attach($eventManager);
    }
}
