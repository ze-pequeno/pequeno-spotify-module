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
        // retrieve spotify from service from factory
        $spotify = $this->getServiceManager()->get('Pequeno\Services\Spotify');

        // assert spotify service is valid instance
        $this->assertInstanceOf('PequenoSpotifyModule\Spotify', $spotify);
    }

    public function testWillInstanciateSpotifyServiceFromAlias()
    {
        // retrieve spotify from service from alias
        $spotify = $this->getServiceManager()->get('pequeno.services.spotify');

        // assert spotify service is valid instance
        $this->assertInstanceOf('PequenoSpotifyModule\Spotify', $spotify);
    }

    public function testSpotifyServiceFromAliasAndFactoryAreSame()
    {
        // retrieve spotify service from factory
        $spotifyFromFactory = $this->getServiceManager()->get('Pequeno\Services\Spotify');

        // retrieve spotify service from alias
        $spotifyFromAlias = $this->getServiceManager()->get('pequeno.services.spotify');

        // assert instance are same
        $this->assertSame($spotifyFromFactory, $spotifyFromAlias);
    }
}
