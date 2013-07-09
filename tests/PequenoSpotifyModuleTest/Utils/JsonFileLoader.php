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
namespace PequenoSpotifyModuleTest\Utils;

// set used namespaces
use Zend\Json\Json;

class JsonFileLoader
{

    /**
     * Load json albums file
     * @access public
     * @static
     * @return object
     */
    public static function loadAlbums()
    {
        // load file
        return self::loadFile('albums.json');
    }

    /**
     * Load json artists file
     * @access public
     * @static
     * @return object
     */
    public static function loadArtists()
    {
        // load file
        return self::loadFile('artists.json');
    }

    /**
     * Load json tracks file
     * @access public
     * @static
     * @return object
     */
    public static function loadTracks()
    {
        // load file
        return self::loadFile('tracks.json');
    }

    /**
     * Load json file from _files directory
     * @access private
     * @static
     * @param  string $file File to load
     * @return object
     */
    private static function loadFile($file)
    {
        // return file content as object
        return Json::decode(file_get_contents(__DIR__.'/../_files/'.$file));
    }
}
