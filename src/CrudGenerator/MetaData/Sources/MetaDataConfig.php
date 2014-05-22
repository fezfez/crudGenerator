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
namespace CrudGenerator\MetaData\Sources;

/**
 * Metadata DAO interface
 *
 * @author Stéphane Demonchaux
 */
interface MetaDataConfig
{
    /**
     * Get config definition
     *
     * @return string
     */
    public function getDefinition();
    /**
     * Get unique configuration name
     * @return string
     */
    public function getUniqueName();
    /**
     * @return connection
     */
    public function getConnection();
    /**
     * @throws ConfigException
     * @return void
     */
    public function test();
    /**
     * @return array
     */
    public function jsonSerialize();
    /**
     * Get MetaDataDAOFactory
     *
     * @return string
     */
    public function getMetaDataDAOFactory();
    /**
     * Set MetaDataDAOFactory
     *
     * @return MetaDataConfig
     */
    public function setMetaDataDAOFactory($value);
}