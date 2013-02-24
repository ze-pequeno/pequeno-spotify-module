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

// try to get composer loader (from module or application directory)
if (!($loader = @include __DIR__.'/../vendor/autoload.php') &&
    !($loader = @include __DIR__.'/../../../autoload.php')) {

    // setup local directories to search ZF2 library
    $directories = array(
        'E:/library/zend/zendframework2/latest/library/',
        'G:/library/zend/zendframework2/latest/library/',
    );

    // iterate search directories
    foreach ($directories as $directory) {

        // get real path
        $directory = realpath($directory);

        // check search directories exist
        if ($directory) {

            // define ZF2_PATH constant and break
            define('ZF2_PATH', $directory);
            break;
        }
    }

    // check if ZF2_PATH is defined
    if (!defined('ZF2_PATH')) {

        // throw RuntimeException indicate autoload file not found
        throw new RuntimeException('"ZF2_PATH" is not defined and vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
    }

    // set include path to include ZF2
    set_include_path(implode(PATH_SEPARATOR, array(
        ZF2_PATH,
        get_include_path()
    )));

    // require Zend Autoloader class
    require 'Zend/Loader/AutoloaderFactory.php';
    require 'Zend/Loader/StandardAutoloader.php';

    // setup autoloader from factory
    \Zend\Loader\AutoloaderFactory::factory(
        array(
            \Zend\Loader\AutoloaderFactory::STANDARD_AUTOLOADER => array(
                \Zend\Loader\StandardAutoloader::AUTOREGISTER_ZF => true,
                \Zend\Loader\StandardAutoloader::ACT_AS_FALLBACK => false,
                \Zend\Loader\StandardAutoloader::LOAD_NS => array(
                    'PequenoSpotifyModule' => __DIR__.'/../src/PequenoSpotifyModule',
                    'PequenoSpotifyModuleTest' => __DIR__.'/../tests/PequenoSpotifyModuleTest'
                ),
            )
        )
    );
}

// try to get TestConfiguration.php
if (!$config = @include __DIR__.'/TestConfiguration.php') {

    // try to get TestConfiguration.php.dist
    $config = require __DIR__.'/TestConfiguration.php.dist';
}

// set Configuration to ServiceManagerFactory
\PequenoSpotifyModuleTest\Utils\ServiceManagerFactory::setConfig($config);
