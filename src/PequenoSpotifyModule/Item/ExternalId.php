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

class ExternalId
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $type;

    /**
     * Class constructor
     * @access public
     * @return ExternalId
     */
    public function __construct()
    {
    }

    /**
     * Set ExternalId identifier
     * @access public
     * @param  string     $id ExternalId identifier
     * @return ExternalId
     */
    public function setId($id)
    {
        // store identifier and return self
        $this->id = (string) $id;

        return $this;
    }

    /**
     * Get ExternalId identifier
     * @access public
     * @return string
     */
    public function getId()
    {
        // return ExternalId identifier
        return (string) $this->id;
    }

    /**
     * Set ExternalId type
     * @access public
     * @param  string     $type ExternalId type
     * @return ExternalId
     */
    public function setType($type)
    {
        // store type and return self
        $this->type = (string) $type;

        return $this;
    }

    /**
     * Set ExternalId type
     * @access public
     * @return string
     */
    public function getType()
    {
        // return ExternalId type
        return (string) $this->type;
    }

    /**
     * Extract ExternalId informations from object
     * @access public
     * @static
     * @param  \stdClass  $externalId Object represent ExternalId
     * @return ExternalId
     */
    public static function extractInfos($externalId)
    {
        // create ExternalId instance
        $externalIdItem = new self();

        // update informations
        $externalIdItem->setId((string) $externalId->id);
        $externalIdItem->setType((string) $externalId->type);

        // return instance
        return $externalIdItem;
    }
}
