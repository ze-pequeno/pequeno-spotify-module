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

class LookupArtistTest extends TestCase
{

    /** @var string */
    const ARTIST_URI = 'spotify:artist:4YrKBkKSVeqDamzBPWVnSJ';

    public function testWillRetriveArtistWithBasicDetails()
    {
        // retrieve artist from Spotify URI
        $artist = $this->getSpotifyService()->lookupArtist(self::ARTIST_URI, 'basic');

        // artist assertions
        $this->assertInstanceOf('PequenoSpotifyModule\Item\Artist', $artist);
        $this->assertEquals(self::ARTIST_URI, $artist->getUri());
        $this->assertEquals('Basement Jaxx', $artist->getName());
	    $this->assertSame(0.0, $artist->getPopularity());

	    // albums assertions
	    $this->assertEmpty($artist->getAlbums());
    }

    public function testWillRetriveArtistWithMediumDetails()
    {
	    // retrieve artist from Spotify URI
	    $artist = $this->getSpotifyService()->lookupArtist(self::ARTIST_URI, 'album');

	    // artist assertions
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\Artist', $artist);
	    $this->assertEquals(self::ARTIST_URI, $artist->getUri());
	    $this->assertEquals('Basement Jaxx', $artist->getName());
	    $this->assertSame(0.0, $artist->getPopularity());
	    // albums assertions
	    $this->assertNotEmpty($artist->getAlbums());
	    $albums = $artist->getAlbums();
	    /** @var $album \PequenoSpotifyModule\Item\Album */
	    $album = reset($albums);
        $this->assertInstanceOf('PequenoSpotifyModule\Item\Album', $album);
        $this->assertEquals('spotify:album:4VmkkYn0IMJovQUWORavXf', $album->getUri());
        $this->assertEquals('Jaxx Unreleased II', $album->getName());
	    $this->assertNotEmpty($album->getTerritories());
	    $this->assertEmpty($album->getReleased());
	    $this->assertEmpty($album->getArtists());
	    $this->assertEmpty($album->getExternalIds());
	    $this->assertEmpty($album->getTracks());

        // album artist assertions
	    $this->assertSame($artist, $album->getArtist());
        $this->assertEquals('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $album->getArtist()->getUri());
        $this->assertEquals('Basement Jaxx', $album->getArtist()->getName());
	    $this->assertSame($artist->getAlbums(), $album->getArtist()->getAlbums());
	    $this->assertEmpty($album->getArtist()->getPopularity());
    }

    public function testWillRetriveArtistWithFullDetails()
    {
	    // retrieve artist from Spotify URI
	    $artist = $this->getSpotifyService()->lookupArtist(self::ARTIST_URI, 'albumdetail');

	    // artist assertions
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\Artist', $artist);
	    $this->assertEquals(self::ARTIST_URI, $artist->getUri());
	    $this->assertEquals('Basement Jaxx', $artist->getName());
	    $this->assertSame(0.0, $artist->getPopularity());
	    // albums assertions
	    $this->assertNotEmpty($artist->getAlbums());
	    $albums = $artist->getAlbums();
	    /** @var $album \PequenoSpotifyModule\Item\Album */
	    $album = reset($albums);
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\Album', $album);
	    $this->assertEquals('spotify:album:4VmkkYn0IMJovQUWORavXf', $album->getUri());
	    $this->assertEquals('Jaxx Unreleased II', $album->getName());
	    $this->assertNotEmpty($album->getTerritories());
	    $this->assertEmpty($album->getArtists());
	    $this->assertEmpty($album->getTracks());
	    $this->assertNotEmpty($album->getExternalIds());
	    $this->assertSame('2010', $album->getReleased());

	    // album external ids assertions
	    $this->assertNotEmpty($album->getExternalIds());
	    $externalIds = $album->getExternalIds();
	    /** @var $externalId \PequenoSpotifyModule\Item\ExternalId */
	    $externalId = reset($externalIds);
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\ExternalId', $externalId);
	    $this->assertSame('5051083056144', $externalId->getId());
	    $this->assertSame('upc', $externalId->getType());
	    
	    // album artist assertions
	    $this->assertSame($artist, $album->getArtist());
	    $this->assertEquals('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $album->getArtist()->getUri());
	    $this->assertEquals('Basement Jaxx', $album->getArtist()->getName());
	    $this->assertSame($artist->getAlbums(), $album->getArtist()->getAlbums());
	    $this->assertEmpty($album->getArtist()->getPopularity());
    }

}
