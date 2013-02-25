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

class LookupAlbumTest extends TestCase
{

    /** @var string */
    const ALBUM_URI = 'spotify:album:6G9fHYDCoyEErUkHrFYfs4';

    public function testWillRetriveAlbumWithBasicDetails()
    {
        $album = $this->getSpotifyService()->lookupAlbum(self::ALBUM_URI, 'basic');

        // album assertions
        $this->assertInstanceOf('PequenoSpotifyModule\Item\Album', $album);
        $this->assertEquals(self::ALBUM_URI, $album->getUri());
        $this->assertEquals('Remedy', $album->getName());
        $this->assertEquals('1999', $album->getReleased());

        // artist assertions
        $this->assertEquals('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $album->getArtist()->getUri());
        $this->assertEquals('Basement Jaxx', $album->getArtist()->getName());
	    $this->assertNotEmpty($album->getExternalIds());

        // external ids assertions
	    /** @var \PequenoSpotifyModule\Item\ExternalId $externalId  */
	    $externalId = reset($album->getExternalIds());
	    $this->assertSame('634904012922', $externalId->getId());
        $this->assertSame('upc', $externalId->getType());

        // tracks assertions
	    $this->assertEmpty($album->getTracks());
    }

    public function testWillRetriveAlbumWithMeduimDetails()
    {
        $album = $this->getSpotifyService()->lookupAlbum(self::ALBUM_URI, 'track');

        // album assertions
        $this->assertInstanceOf('PequenoSpotifyModule\Item\Album', $album);
        $this->assertEquals(self::ALBUM_URI, $album->getUri());
        $this->assertEquals('Remedy', $album->getName());
        $this->assertEquals('1999', $album->getReleased());

        // artist assertions
        $this->assertEquals('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $album->getArtist()->getUri());
        $this->assertEquals('Basement Jaxx', $album->getArtist()->getName());
	    $this->assertNotEmpty($album->getExternalIds());

        // external ids assertions
	    /** @var \PequenoSpotifyModule\Item\ExternalId $externalId  */
	    $externalId = reset($album->getExternalIds());
	    $this->assertSame('634904012922', $externalId->getId());
	    $this->assertSame('upc', $externalId->getType());

        // tracks assertions
	    $this->assertNotEmpty($album->getTracks());
        /** @var \PequenoSpotifyModule\Item\Track $track  */
        $track = reset($album->getTracks());
        $this->assertSame('spotify:track:3zBhJBEbDD4a4SO1EaEiBP', $track->getUri());
        $this->assertSame('Rendez-vu', $track->getName());
        $this->assertSame(0, $track->getTrackNumber());
        $this->assertSame(0, $track->getDiscNumber());
        $this->assertSame(0.0, $track->getLength());
        $this->assertSame(0.0, $track->getPopularity());

        // track artists assertions
	    $this->assertNotEmpty($track->getArtists());
        /** @var \PequenoSpotifyModule\Item\Artist $trackArtist  */
        $trackArtist = reset($track->getArtists());
        $this->assertSame('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $trackArtist->getUri());
        $this->assertSame('Basement Jaxx', $trackArtist->getName());
    }

    public function testWillRetriveAlbumWithFullDetails()
    {
        $album = $this->getSpotifyService()->lookupAlbum(self::ALBUM_URI, 'trackdetail');

        // album assertions
        $this->assertInstanceOf('PequenoSpotifyModule\Item\Album', $album);
        $this->assertEquals(self::ALBUM_URI, $album->getUri());
        $this->assertEquals('Remedy', $album->getName());
        $this->assertEquals('1999', $album->getReleased());

        // artist assertions
        $this->assertEquals('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $album->getArtist()->getUri());
        $this->assertEquals('Basement Jaxx', $album->getArtist()->getName());
	    $this->assertNotEmpty($album->getExternalIds());

        // external ids assertions
	    /** @var \PequenoSpotifyModule\Item\ExternalId $externalId  */
	    $externalId = reset($album->getExternalIds());
	    $this->assertSame('634904012922', $externalId->getId());
	    $this->assertSame('upc', $externalId->getType());

        // tracks assertions
	    $this->assertNotEmpty($album->getTracks());
        /** @var \PequenoSpotifyModule\Item\Track $track  */
        $track = reset($album->getTracks());
        $this->assertSame('spotify:track:3zBhJBEbDD4a4SO1EaEiBP', $track->getUri());
        $this->assertSame('Rendez-vu', $track->getName());
        $this->assertSame(1, $track->getTrackNumber());
        $this->assertSame(1, $track->getDiscNumber());
        $this->assertSame(346.158, $track->getLength());
        $this->assertSame(0.36000, $track->getPopularity());

        // track artists assertions
	    $this->assertNotEmpty($track->getArtists());
        /** @var \PequenoSpotifyModule\Item\Artist $trackArtist  */
        $trackArtist = reset($track->getArtists());
        $this->assertSame('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $trackArtist->getUri());
        $this->assertSame('Basement Jaxx', $trackArtist->getName());
    }

}
