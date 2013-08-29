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
namespace CrudGenerator\MetaData\Sources\Doctrine2;

use CrudGenerator\EnvironnementResolver\ZendFramework2Environnement;
use CrudGenerator\Utils\FileManager;

/**
 * Doctrine2 Metadata DAO in Zend Framework 2 Environnement
 *
 * @CodeGenerator\Environnement ZendFramework2Environnement
 * @CodeGenerator\Description Doctrine2
 * @author Stéphane Demonchaux
 */
class Doctrine2MetaDataDAOFactory
{
    /**
     * Create Doctrine2MetaDataDAO instance
     * @return \CrudGenerator\MetaData\MetaDataDAO
     */
    public static function getInstance()
    {
        $fileManager    = new FileManager();
        $serviceManager = ZendFramework2Environnement::getDependence($fileManager);
        $entityManager  = $serviceManager->get('doctrine.entitymanager.orm_default');

        return new Doctrine2MetaDataDAO($entityManager);
    }
}