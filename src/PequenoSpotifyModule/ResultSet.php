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
namespace PequenoSpotifyModule;

// set used namespaces
use PequenoSpotifyModule\Service\SpotifyService,
    PequenoSpotifyModule\Item\AbstractItem,
    PequenoSpotifyModule\Item\Album,
    PequenoSpotifyModule\Item\Artist,
    PequenoSpotifyModule\Item\ExternalId,
    PequenoSpotifyModule\Item\Track;

class ResultSet implements \Iterator, \Countable
{

    /** @var int */
    protected $_numResults = null;

    /** @var int */
    protected $_limit = null;

    /** @var int */
    protected $_offset = null;

    /** @var string */
    protected $_query = null;

    /** @var string */
    protected $_type = null;

    /** @var int */
    protected $_numPage = null;

    /** @var AbstractItem[] */
    protected $_results = null;

    /**
     * Class contructor
     * @access public
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    public function __construct($rawResults)
    {
        // initialize datas
        $this->initialize();

        // extract search informations
        $this->extractSearchInfos($rawResults);

        // extract search results
        $this->extractSearchResults($rawResults);
    }

    /**
     * Initialize datas
     * @access protected
     * @return ResultSet
     */
    protected function initialize()
    {
        // initialize datas
        $this->_numResults 	= 0;
        $this->_numPage		= 0;
        $this->_limit 		= 0;
        $this->_offset 		= 0;
        $this->_query		= '';
        $this->_type		= '';
        $this->_results	    = array();

        // return ResultSet
        return $this;
    }

    /**
     * Get result total number
     * @access public
     * @return int
     */
    public function getSizeOfResults()
    {
        // return result total number
        return $this->_numResults;
    }

    /**
     * Permet d'ajouter un item dans les résultats
     * @access private
     * @param  AbstractItem   $item Item à intégrer dans le jeu de résultat
     * @return AbstractItem[]
     */
    private function _addSearchResult($item)
    {
        // create container if necessary
        if (!is_array($this->_results)) $this->_results = array();

        // check we have an AbstractItem instance
        if ($item instanceof AbstractItem) {

            // add item to container
            $this->_results[] = $item;
        }

        // return container
        return $this->_results;
    }

    /**
     * Extract search informations
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractSearchInfos($rawResults)
    {
        // is search informations available ?
        if (isset($rawResults->info)) {

            // get search informations
            $this->_numResults 	= (int) $rawResults->info->num_results;
            $this->_numPage		= (int) $rawResults->info->page;
            $this->_limit 		= (int) $rawResults->info->limit;
            $this->_offset 		= (int) $rawResults->info->offset;
            $this->_query		= (string) $rawResults->info->query;
            $this->_type		= (string) $rawResults->info->type;
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search result items
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractSearchResults($rawResults)
    {
        switch ($this->_type) {
            // albums search
            case SpotifyService::SEARCH_ALBUM: {
                $this->extractAlbums($rawResults);
                break;
            }
            // artists search
            case SpotifyService::SEARCH_ARTIST: {
                $this->extractArtists($rawResults);
                break;
            }
            // tracks search
            case SpotifyService::SEARCH_TRACK: {
                $this->extractTracks($rawResults);
                break;
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search albums
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractAlbums($rawResults)
    {
        // are albums available ?
        if (isset($rawResults->albums) AND is_array($rawResults->albums)) {

            // iterate albums
            foreach ($rawResults->albums as $album) {

                // create album instance
                $albumItem = Album::extractInfos($album);

                // store search result
                $this->_addSearchResult($albumItem);
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search artists
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractArtists($rawResults)
    {
        // are artists available ?
        if (isset($rawResults->artists) AND is_array($rawResults->artists)) {

            // iterate artists
            foreach ($rawResults->artists as $artist) {

                // create artist instance
                $artistItem = Artist::extractInfos($artist);

                // store search result
                $this->_addSearchResult($artistItem);
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Extract search tracks
     * @access protected
     * @param  \stdClass $rawResults Raw result from SpotifyService
     * @return ResultSet
     */
    protected function extractTracks($rawResults)
    {
        // are tracks available ?
        if (isset($rawResults->tracks) AND is_array($rawResults->tracks)) {

            // iterate tracks
            foreach ($rawResults->tracks as $track) {

                // create Track instance
                $trackItem = Track::extractInfos($track);

                // store search result
                $this->_addSearchResult($trackItem);
            }
        }

        // return ResultSet
        return $this;
    }

    /**
     * Get search resultat as indice
     * @access public
     * @param  int               $indice Search result indice
     * @return AbstractItem|null
     */
    public function getResultAt($indice)
    {
        // return AbstractItem if exist, else null
        return (isset($this->_results[$indice])) ? $this->_results[$indice] : null;
    }

    /**
     * Get current search AbstractItem
     * @access public
     * @return AbstractItem
     */
    public function current()
    {
        // return current AbstractItem
        return current($this->_results);
    }

    /**
     * Move cursor to next position
     * @access public
     * @return void
     */
    public function next()
    {
        next($this->_results);
    }

    /**
     * Get current cursor position
     * @access public
     * @return int
     */
    public function key()
    {
        return key($this->_results);
    }

    /**
     * Is current cursor position valid ?
     * @access public
     * @return bool
     */
    public function valid()
    {
        return (bool) (($this->key() !== null) AND ($this->key() !== false));
    }

    /**
     * Rest cursor position to start
     * @access public
     * @return void
     */
    public function rewind()
    {
        reset($this->_results);
    }

    /**
     * Get search results count (from query, not total)
     * @access public
     * @return int
     */
    public function count()
    {
        // return search result count
        return count($this->_results);
    }

}
