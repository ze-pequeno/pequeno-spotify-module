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
namespace PequenoSpotifyModule\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * The client ID provided to you by Spotify when you register your application.
     * @var string|null
     * @see https://developer.spotify.com/web-api/authorization-guide
     */
    protected $clientId;

    /**
     * The application's client secret key, obtained when the application was registered with Spotify.
     * @var string|null
     * @see https://developer.spotify.com/web-api/authorization-guide
     */
    protected $clientSecret;

    /**
	 * Key of the Http client fetched from service locator
	 * @var string|null
	 */
    protected $httpClient;

    /**
     * Set client ID provided to you by Spotify when you register your application
     * @access public
     * @param  string|null $clientId
     * @return void
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Get client ID provided to you by Spotify when you register your application
     * @access public
     * @return string|null
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Get application's client secret key, obtained when the application was registered with Spotify
     * @access public
     * @return string|null
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Set application's client secret key, obtained when the application was registered with Spotify
     * @access public
     * @param  string|null $clientSecret
     * @return void
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
	 * Get the Http client manager key
     * @access public
     * @return string|null
	 */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Set the Http client key
     * @access public
     * @param  string|null $httpClient
     * @return void
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = (string) $httpClient;
    }
}
