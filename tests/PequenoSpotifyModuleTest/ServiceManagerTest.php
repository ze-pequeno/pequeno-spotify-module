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
namespace PequenoSpotifyModuleTest;

// set used namespaces
use PequenoSpotifyModuleTest\Framework\TestCase;

class ServiceManagerTest extends TestCase
{

    public function testWillInstanciateServiceManager()
    {
        // retrieve service manager
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $this->getServiceManager());
    }

    public function testWillInstanciateSpotifyServiceFromFactory()
    {
        // retrieve spotify service from factory
        $this->assertInstanceOf('PequenoSpotifyModule\Service\SpotifyService', $this->getServiceManager()->get('pequeno.services.spotify'));
    }

    public function testWillInstanciateSpotifyServiceFromAlias()
    {
        // retrieve spotify service from alias
        $this->assertInstanceOf('PequenoSpotifyModule\Service\SpotifyService', $this->getServiceManager()->get('Pequeno\Service\SpotifyService'));
    }

    public function testSpotifyServiceFromAliasAndFactoryAreSame()
    {
        $this->assertSame(
            // retrieve spotify service from factory
            $this->getServiceManager()->get('pequeno.services.spotify'),
            // retrieve spotify service from alias
            $this->getServiceManager()->get('Pequeno\Service\SpotifyService')
        );
    }

}
