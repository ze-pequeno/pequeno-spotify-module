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
use PequenoSpotifyModuleTest\Utils\JsonFileLoader;

class ResultSetTest extends TestCase
{

    public function testAlbumsResultSet()
    {
        $results = new \PequenoSpotifyModule\ResultSet(JsonFileLoader::loadAlbums());
        $this->assertCount(6, $results);
        $this->assertEquals(6, $results->getSizeOfResults());
        $this->assertInstanceOf('\PequenoSpotifyModule\Item\Album', $results->getResultAt(0));
    }

    public function testArtistsResultSet()
    {
        $results = new \PequenoSpotifyModule\ResultSet(JsonFileLoader::loadArtists());
        $this->assertCount(6, $results);
        $this->assertEquals(6, $results->getSizeOfResults());
        $this->assertInstanceOf('\PequenoSpotifyModule\Item\Artist', $results->getResultAt(0));
    }

    public function testTracksResultSet()
    {
        $results = new \PequenoSpotifyModule\ResultSet(JsonFileLoader::loadTracks());
        $this->assertCount(100, $results);
        $this->assertEquals(1650, $results->getSizeOfResults());
        $this->assertInstanceOf('\PequenoSpotifyModule\Item\Track', $results->getResultAt(0));
    }

    public function testCanIterateResultSet()
    {
        $results = new \PequenoSpotifyModule\ResultSet(JsonFileLoader::loadAlbums());
        foreach ($results as $key => $result) {
            $this->assertSame($results->getResultAt($key), $result);
        }
    }
}
