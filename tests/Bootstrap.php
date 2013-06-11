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

// enable all error reporting
ini_set('error_reporting', E_ALL);

// setup files for retrieve composer autoloader
$files = array(__DIR__.'/../vendor/autoload.php', __DIR__.'/../../../autoload.php');

// iterate all files
foreach ($files as $file) {

    // check file exist
    if (file_exists($file)) {

        // include loader
        $loader = require $file;
        break;
    }
}

// check composer autoloader exist
if (!isset($loader)) {

    // throw RuntimeException indicate composer autoloader is not found
    throw new RuntimeException('vendor/autoload.php could not be found. Did you install via composer?');
}

// add PequenoSpotifyModuleTest to loader
$loader->add('PequenoSpotifyModuleTest', __DIR__);

// setup files for retrieve configuration
$configFiles = array(__DIR__.'/TestConfiguration.php', __DIR__.'/TestConfiguration.php.dist');

// iterate all files
foreach ($configFiles as $configFile) {

    // check file exist
    if (file_exists($configFile)) {

        // include loader
        $config = require $configFile;
        break;
    }
}

// set Configuration to ServiceManagerFactory
\PequenoSpotifyModuleTest\Utils\ServiceManagerFactory::setConfig($config);

// unset references
unset($file, $file, $loader, $configFiles, $configFile, $config);
