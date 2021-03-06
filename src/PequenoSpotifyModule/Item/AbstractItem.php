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

abstract class AbstractItem
{
    /** @var string */
    protected $uri;

    /** @var string */
    protected $name;

    /** @var float */
    protected $popularity;

    /**
     * Class constructor
     * @access public
     * @return AbstractItem
     */
    public function __construct()
    {
    }

    /**
     * Set item name
     * @access public
     * @param  string       $name Item name
     * @return AbstractItem
     */
    public function setName($name)
    {
        // store item name and return self
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Get item name
     * @access public
     * @return string
     */
    public function getName()
    {
        // return item name
        return (string) $this->name;
    }

    /**
     * Set item populatiry
     * @access public
     * @param  float        $popularity Item popularity
     * @return AbstractItem
     */
    public function setPopularity($popularity)
    {
        // store popularity and return self
        $this->popularity = (float) $popularity;

        return $this;
    }

    /**
     * Get item populatiry
     * @access public
     * @return float
     */
    public function getPopularity()
    {
        // return item popularity
        return (float) $this->popularity;
    }

    /**
     * Set item URI
     * @access public
     * @param  string       $uri Item URI
     * @return AbstractItem
     */
    public function setUri($uri)
    {
        // store item URI and return self
        $this->uri = (string) $uri;

        return $this;
    }

    /**
     * Get item URI
     * @access public
     * @return string
     */
    public function getUri()
    {
        return (string) $this->uri;
    }
}
