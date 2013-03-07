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
namespace PequenoSpotifyModule\Item;

class Track extends AbstractItem
{

    /** @var int */
    protected $_discNumber;

    /** @var float */
    protected $_length;

    /** @var int */
    protected $_trackNumber;

    /** @var Album */
    protected $_album;

    /** @var Artist[] */
    protected $_artists;

    /** @var ExternalId[] */
    protected $_externalIds;

    /** @var string[] */
    protected $_territories;

    /**
     * Set track length
     * @access public
     * @param  float $length Track length
     * @return Track
     */
    public function setLength($length)
    {
        // store lenght and return self
        $this->_length = (float) $length;

        return $this;
    }

    /**
     * Get track length
     * @access public
     * @return float
     */
    public function getLength()
    {
        // return tracj length
        return (float) $this->_length;
    }

    /**
     * Set track disc number
     * @access public
     * @param  int   $discNumber Track disc number
     * @return Track
     */
    public function setDiscNumber($discNumber)
    {
        // store disc number and return self
        $this->_discNumber = (int) $discNumber;

        return $this;
    }

    /**
     * Get track disc number
     * @access public
     * @return int
     */
    public function getDiscNumber()
    {
        // return disc number
        return (int) $this->_discNumber;
    }

    /**
     * Set track number
     * @access public
     * @param  int   $trackNumber Track number
     * @return Track
     */
    public function setTrackNumber($trackNumber)
    {
        // store track number and return self
        $this->_trackNumber = (int) $trackNumber;

        return $this;
    }

    /**
     * Get track number
     * @access public
     * @return int
     */
    public function getTrackNumber()
    {
        // return track number
        return (int) $this->_trackNumber;
    }

    /**
     * Set album territories availability
     * @access public
     * @param  string[] $territories Album territories availability
     * @return Album
     */
    public function setTerritories($territories)
    {
        // store territories availability and return self
        $this->_territories = (array) $territories;

        return $this;
    }

    /**
     * Get album territories availability
     * @access public
     * @return string[]
     */
    public function getTerritories()
    {
        // return territories availability
        return (array) $this->_territories;
    }

    /**
     * Set artists of track
     * @access public
     * @param  Artist[] $artists Artists of track
     * @return Track
     */
    public function setArtists($artists)
    {
        // store artists and return self
        $this->_artists = (array) $artists;

        return $this;
    }

    /**
     * Set artists of track
     * @access public
     * @return Artist[]
     */
    public function getArtists()
    {
        // return artists
        return (array) $this->_artists;
    }

    /**
     * Set album of track
     * @access public
     * @param  Album $album Album of track
     * @return Track
     */
    public function setAlbum($album)
    {
        // store album and return self
        $this->_album = $album;

        return $this;
    }

    /**
     * Get album of track
     * @access public
     * @return Album
     */
    public function getAlbum()
    {
        // return album
        return $this->_album;
    }

    /**
     * Set track external ids
     * @access public
     * @param  ExternalId[] $externalIds Track external ids
     * @return Track
     */
    public function setExternalIds($externalIds)
    {
        // store external ids and return self
        $this->_externalIds = (array) $externalIds;

        return $this;
    }

    /**
     * Get track external ids
     * @access public
     * @return ExternalId[]
     */
    public function getExternalIds()
    {
        // return track external ids
        return (array) $this->_externalIds;
    }

    /**
     * Extract Track informations from object
     * @access public
     * @static
     * @param  \stdClass $track Object represent Track
     * @return Track
     */
    public static function extractInfos($track)
    {
        // create Track instance
        $trackItem = new self();

        // update informations
        $trackItem->setUri((string) $track->href);
        $trackItem->setName((string) $track->name);

        // is popularity available ?
        if (isset($track->popularity)) {

            // update popularity
            $trackItem->setPopularity((float) $track->popularity);
        }

        // is disc number available ?
        if (isset($track->{'disc-number'})) {

            // update disc number
            $trackItem->setDiscNumber($track->{'disc-number'});
        }

        // is track number available ?
        if (isset($track->{'track-number'})) {

            // update track number
            $trackItem->setTrackNumber($track->{'track-number'});
        }

        // is track length available ?
        if (isset($track->length)) {

            // update track length
            $trackItem->setLength($track->length);
        }

        // is track albul available ?
        if (isset($track->album)) {

            // update track album
            $trackItem->setAlbum(Album::extractInfos($track->album));
        }

        // is artists available ?
        if (isset($track->artists) && is_array($track->artists)) {

            // setup artists container
            $artists = array();

            // iterate artists
            foreach ($track->artists as $artist) {

                // create Artist and store on container
                $artists[] = Artist::extractInfos($artist);
            }

            // set artists of track
            $trackItem->setArtists($artists);
        }

        // is external ids available ?
        if (isset($track->{'external-ids'}) && is_array($track->{'external-ids'})) {

            // setup external ids container
            $externalIds = array();

            // iterate external ids
            foreach ($track->{'external-ids'} as $externalId) {

                // create ExternalId and store on container
                $externalIds[] = ExternalId::extractInfos($externalId);
            }

            // set external ids of track
            $trackItem->setExternalIds($externalIds);
        }

        // is teritories availabality available ?
        if (isset($track->availability) && isset($track->availability->territories)) {

            // update territories availability
            $trackItem->setTerritories(explode(' ', $track->availability->territories));
        }

        // on retourne l'instance de la piste
        return $trackItem;
    }

}
