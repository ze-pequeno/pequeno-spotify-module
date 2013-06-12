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
namespace PequenoSpotifyModule\Service;

// set used namespaces
use PequenoSpotifyModule\Item as SpotifyItem;
use PequenoSpotifyModule\ResultSet;
use Zend\Http\Exception\RuntimeException as ZendRuntimeException;
use Zend\Http\Client as HttpClient;
use Zend\Http\Header\ContentType as ContentTypeHeader;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;

class SpotifyService
{

    /** @var string */
    const URI_API = 'http://ws.spotify.com';

    /** @var string */
    const SEARCH_SERVICE = 'search';

    /** @var string */
    const SEARCH_ARTIST = 'artist';

    /** @var string */
    const SEARCH_ALBUM = 'album';

    /** @var string */
    const SEARCH_TRACK = 'track';

    /** @var string */
    const LOOKUP_SERVIVE = 'lookup';

    /** @var string */
    const LOOKUP_ALBUM = 'spotify:album:%s';

    /** @var string */
    const LOOKUP_ARTIST = 'spotify:artist:%s';

    /** @var string */
    const LOOKUP_TRACK = 'spotify:track:%s';

    /** @var string */
    const URI_FORMAT = '%s/%s/%d/%s.%s';

    /** @var string */
    const PARAM_QUERY = 'q';

    /** @var string */
    const PARAM_PAGE = 'page';

    /** @var string */
    const PARAM_URI = 'uri';

    /** @var string */
    const PARAM_EXTRA = 'extras';

    /** @var string */
    const FORMAT_JSON = 'json';

    /** @var string */
    const FORMAT_XML = 'xml';

    /** @var string */
    const ACCEPT_HEADER_JSON = 'application/json';

    /** @var string */
    const ACCEPT_HEADER_XML = 'application/xml, text/xml';

    /** @var HttpClient */
    protected $httpClient;

    /** @var HttpResponse */
    protected $response;

    /** @var string */
    protected $format;

    /** @var int */
    protected $version;

    /**
     * Class constructor
     * @access public
     * @return SpotifyService
     */
    public function __construct()
    {
        // force version and format
        $this->setVersion(1);
        $this->setFormat(self::FORMAT_JSON);
    }

    /**
     * Set API version to use
     * @access protected
     * @param  int            $version API version to use
     * @return SpotifyService
     */
    protected function setVersion($version)
    {
        // store version and return self
        $this->version = (int) $version;

        return $this;
    }

    /**
     * Get API version to use
     * @access protected
     * @return int
     */
    protected function getVersion()
    {
        // return version
        return $this->version;
    }

    /**
     * Set response format
     * @access public
     * @param  string         $format Response format
     * @return SpotifyService
     */
    public function setFormat($format)
    {
        // check if format is not valid
        if (!in_array($format, array(self::FORMAT_JSON, self::FORMAT_XML))) {

            // force format to JSON
            $format = self::FORMAT_JSON;
        }

        // store format and return self
        $this->format = $format;

        return $this;
    }

    /**
     * Get response format
     * @access public
     * @return string
     */
    public function getFormat()
    {
        // return response format
        return $this->format;
    }

    /**
     * Get HttpClient instance
     * @access protected
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        // check we don't have \Zend\Http\Client instance
        if (!($this->httpClient instanceof HttpClient)) {

            // create and store HttpClient
            $this->setHttpClient(new HttpClient());
        }

        // return \Zend\Http\Client instance
        return $this->httpClient;
    }

    /**
     * Set HttpClient instance
     * @access protected
     * @param  HttpClient     $httpClient HttpClient instance
     * @return SpotifyService
     */
    protected function setHttpClient($httpClient)
    {
        // store HttpClient and return self
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Lookup album from Spotify according URI
     * @access public
     * @param  string            $uri    Spotify URI
     * @param  string            $detail Lookup detail
     * @return SpotifyItem\Album
     */
    public function lookupAlbum($uri, $detail = 'basic')
    {
        // update extra parameter
        $extrasParam = strtolower($detail);
        switch ($extrasParam) {
            case 'track':
            case 'trackdetail':
                break;
            case 'basic':
            default:
                $extrasParam = '';
                break;
        }

        // setup service parameters
        $parameters = array(
            self::PARAM_URI     => $this->generateUriParameter($uri, self::LOOKUP_ALBUM),
            self::PARAM_EXTRA   => $extrasParam
        );

        // lookup album from Spotify
        $rawResult = $this->send(self::LOOKUP_SERVIVE, '', $parameters);

        // return SpotifyItem\Album instance
        return SpotifyItem\Album::extractInfos($rawResult->album);
    }

    /**
     * Lookup artist from Spotify according URI
     * @access public
     * @param  string             $uri    Spotify URI
     * @param  string             $detail Lookup detail
     * @return SpotifyItem\Artist
     */
    public function lookupArtist($uri, $detail = 'basic')
    {
        // update extra parameter
        $extrasParam = strtolower($detail);
        switch ($extrasParam) {
            case 'album':
            case 'albumdetail':
                break;
            case 'basic':
            default:
                $extrasParam = '';
                break;
        }

        // setup parameters
        $parameters = array(
            self::PARAM_URI     => $this->generateUriParameter($uri, self::LOOKUP_ARTIST),
            self::PARAM_EXTRA   => $extrasParam
        );

        // lookup artist from Spotify
        $rawResult = $this->send(self::LOOKUP_SERVIVE, '', $parameters);

        // return SpotifyItem\Artist instance
        return SpotifyItem\Artist::extractInfos($rawResult->artist);
    }

    /**
     * Lookup track from Spotify according URI
     * @access public
     * @param  string            $uri Spotify URI
     * @return SpotifyItem\Track
     */
    public function lookupTrack($uri)
    {
        // setup parameters
        $parameters = array(
            self::PARAM_URI     => $this->generateUriParameter($uri, self::LOOKUP_TRACK)
        );

        // lookup track from Spotify
        $rawResult = $this->send(self::LOOKUP_SERVIVE, '', $parameters);

        // return SpotifyItem\Track instance
        return SpotifyItem\Track::extractInfos($rawResult->track);
    }

    /**
     * Search album from Spotify catalogue
     * @access public
     * @param  string    $album Album name to search
     * @param  int       $page  Page number
     * @return ResultSet
     */
    public function searchAlbum($album, $page = 1)
    {
        // setup parameters
        $parameters = array(
            self::PARAM_QUERY   => $this->generateQueryParameter($album),
            self::PARAM_PAGE    => $this->generatePageParameter($page)
        );

        // search album from Spotify
        $rawResult = $this->send(self::SEARCH_SERVICE, self::SEARCH_ALBUM, $parameters);

        // return ResultSet
        return new ResultSet($rawResult);
    }

    /**
     * Search artist from Spotify catalogue
     * @access public
     * @param  string    $artist Artist name to search
     * @param  int       $page   Page number
     * @return ResultSet
     */
    public function searchArtist($artist, $page = 1)
    {
        // setup parameters
        $parameters = array(
            self::PARAM_QUERY   => $this->generateQueryParameter($artist),
            self::PARAM_PAGE    => $this->generatePageParameter($page)
        );

        // search artist from Spotify
        $rawResult = $this->send(self::SEARCH_SERVICE, self::SEARCH_ARTIST, $parameters);

        // return ResultSet
        return new ResultSet($rawResult);
    }

    /**
     * Search track from Spotify catalogue
     * @access public
     * @param  string    $track Track name to search
     * @param  int       $page  Page number
     * @return ResultSet
     */
    public function searchTrack($track, $page = 1)
    {
        // setup parameters
        $parameters = array(
            self::PARAM_QUERY   => $this->generateQueryParameter($track),
            self::PARAM_PAGE    => $this->generatePageParameter($page)
        );

        // search artist from Spotify
        $rawResult = $this->send(self::SEARCH_SERVICE, self::SEARCH_TRACK, $parameters);

        // return ResultSet
        return new ResultSet($rawResult);
    }

    /**
     * Send Http request to retrieve datas
     * @access protected
     * @param  string                                $service    Service to call
     * @param  string                                $type       Resource type to retrieve (for search service)
     * @param  array                                 $parameters Parameters used for request
     * @throws \Zend\Http\Exception\RuntimeException
     * @return \stdClass
     */
    protected function send($service, $type, $parameters)
    {
        // reset old parameters
        $this->getHttpClient()->resetParameters();

        // setup Http headers
        $headers = array(ContentTypeHeader::fromString('Content-Type: '.HttpClient::ENC_URLENCODED));

        // setup HttpClient
        $this->getHttpClient()->setMethod(HttpRequest::METHOD_GET);
        $this->getHttpClient()->setParameterGet($parameters);
        $this->getHttpClient()->setHeaders($headers);

        // generate URI and set to HttpClient
        $this->getHttpClient()->setUri($this->generateURI($service, $type));

        // get HttpResponse
        $this->response = $this->getHttpClient()->send();

        // is HttpRequest ok ?
        if (!$this->response->isOk()) {

            // throw RuntimeException
            throw new ZendRuntimeException(sprintf('Invalid status code: %d', $this->response->getStatusCode()));
        }

        // return decode object
        return \Zend\Json\Decoder::decode($this->response->getBody());
    }

    /**
     * Generate URI to call
     * @access protected
     * @param  string $service Service to call
     * @param  string $type    Resource type
     * @return string
     */
    protected function generateURI($service, $type)
    {
        // update type (force "" for non "search" service)
        $type = ($service === self::SEARCH_SERVICE) ? $type : '';

        // return URI generation
        return sprintf(self::URI_FORMAT, self::URI_API, $service, $this->getVersion(), $type, $this->getFormat());
    }

    /**
     * Generate query parameter
     * @access protected
     * @param  string $parameter Query parameter
     * @return string
     */
    protected function generateQueryParameter($parameter)
    {
        // replace "-" by space except for search tags like "genre:pop" or "label:mylabel"
        $parameter = preg_replace('#(^[^a-z\:]+\-|[\_\(\)])#ui', ' ', trim($parameter));

        // replace multiple spaces by once
        $parameter = preg_replace('#\s{2,}#', ' ', $parameter);

        // return parameter value with urlencode function
        return urlencode(trim($parameter));
    }

    /**
     * Generate page parameter value
     * @access protected
     * @param  int $page Page parameter
     * @return int
     */
    protected function generatePageParameter($page)
    {
        // return page number (first page if not valid)
        return (!is_numeric($page) || ($page < 1)) ? 1 : (int) $page;
    }

    /**
     * Generate lookup URI according format
     * @access public
     * @param  string $uri    Spotify URI
     * @param  string $format Format to used
     * @return string
     */
    protected function generateUriParameter($uri, $format)
    {
        // on regarde si l'URI fourni est complète ou non
        if (substr($uri, 0, 14) != substr($format, 0, 14)) {

            // generate URI according format with last URI parts
            $uri = sprintf($format, end(explode(':', $uri)));
        }

        // return URI
        return $uri;
    }
}
