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

class LookupTrackTest extends TestCase
{

    /** @var string */
    const TRACK_URI = 'spotify:track:3zBhJBEbDD4a4SO1EaEiBP';

    public function testWillRetriveTrack()
    {
        // retrieve track from Spotify URI
        $track = $this->getSpotifyService()->lookupTrack(self::TRACK_URI);

        // track assertions
        $this->assertInstanceOf('PequenoSpotifyModule\Item\Track', $track);
        $this->assertEquals(self::TRACK_URI, $track->getUri());
        $this->assertEquals('Rendez-vu', $track->getName());
	    $this->assertGreaterThan(0.0, $track->getPopularity());
	    $this->assertSame(346.158, $track->getLength());
	    $this->assertSame(1, $track->getTrackNumber());
	    $this->assertEmpty($track->getDiscNumber());
	    $this->assertNotEmpty($track->getTerritories());

	    // artist assertions
	    $this->assertNotEmpty($track->getArtists());
	    $artists = $track->getArtists();
	    /** @var $artist \PequenoSpotifyModule\Item\Artist */
	    $artist = reset($artists);
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\Artist', $artist);
	    $this->assertSame('spotify:artist:4YrKBkKSVeqDamzBPWVnSJ', $artist->getUri());
	    $this->assertSame('Basement Jaxx', $artist->getName());

	    // albums assertions
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\Album', $track->getAlbum());
	    $this->assertEquals('spotify:album:6G9fHYDCoyEErUkHrFYfs4', $track->getAlbum()->getUri());
	    $this->assertEquals('Remedy', $track->getAlbum()->getName());
	    $this->assertEquals('1999', $track->getAlbum()->getReleased());

	    // track external ids assertions
	    $this->assertNotEmpty($track->getExternalIds());
	    $externalIds = $track->getExternalIds();
	    /** @var $externalId \PequenoSpotifyModule\Item\ExternalId */
	    $externalId = reset($externalIds);
	    $this->assertInstanceOf('PequenoSpotifyModule\Item\ExternalId', $externalId);
	    $this->assertSame('GBBKS9900090', $externalId->getId());
	    $this->assertSame('isrc', $externalId->getType());
    }

}
