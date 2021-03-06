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
namespace PequenoSpotifyModuleTest\Framework;

// set used namespaces
use PequenoSpotifyModule\Service\SpotifyService;
use PequenoSpotifyModuleTest\Utils\Bootstrap;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

class TestCase extends PHPUnit_Framework_TestCase
{

    /** @var ServiceManager */
    protected $serviceManager;

    /** @var SpotifyService */
    protected $spotify;

    /**
     * Get \Zend\ServiceManager\ServiceManager instance
     * @access public
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        // check we don't have ServiceManager instance
        if (!($this->serviceManager instanceof ServiceManager)) {

            // get service manager from boostrap
            $this->serviceManager = Bootstrap::getServiceManager();
        }

        // return ServiceManager instance
        return $this->serviceManager;
    }

    /**
     * Get SpotifyService instance
     * @access public
     * @return SpotifyService
     */
    public function getSpotifyService()
    {
        // check we don't have SpotifyService instance
        if (!($this->spotify instanceof SpotifyService)) {

            // create SpotifyService instance from factory
            $this->spotify = $this->getServiceManager()->get('Pequeno\Service\SpotifyService');
        }

        // return SpotifyService instance
        return $this->spotify;
    }
}
