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
namespace PequenoSpotifyModuleTest\Service;

// set used namespaces
use PequenoSpotifyModuleTest\Framework\TestCase;

class SearchAlbumTest extends TestCase
{

    public function testWillSearchAlbum()
    {
        // search albums
        $albums = $this->getSpotifyService()->searchAlbum('random access memories');
        $this->assertCount(10, $albums);
        $this->assertEquals(10, $albums->getSizeOfResults());

        /** @var \PequenoSpotifyModule\Item\Album $album */
        $album = $albums->getResultAt(0);
        $this->assertInstanceOf('\PequenoSpotifyModule\Item\Album', $album);
        $this->assertEquals('spotify:album:4m2880jivSbbyEGAKfITCa', $album->getUri());
        $this->assertEquals('Random Access Memories', $album->getName());
        $this->assertEquals(0.91000, $album->getPopularity());

        /** @var \PequenoSpotifyModule\Item\Artist $artist */
        $artists = $album->getArtists();
        $artist = reset($artists);
        $this->assertInstanceOf('\PequenoSpotifyModule\Item\Artist', $artist);
        $this->assertEquals('spotify:artist:4tZwfgrHOc3mvqYlEYSvVi', $artist->getUri());
        $this->assertEquals('Daft Punk', $artist->getName());
    }
}
