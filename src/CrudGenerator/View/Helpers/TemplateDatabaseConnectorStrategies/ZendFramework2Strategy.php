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
namespace CrudGenerator\View\Helpers\TemplateDatabaseConnectorStrategies;

use CrudGenerator\DataObject;

/**
 * @author stephane.demonchaux
 *
 */
class ZendFramework2Strategy implements StrategyInterface
{
    /**
     * @return string
     */
    public function getFullClass()
    {
        return 'Doctrine\ORM\EntityManager';
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return 'EntityManager';
    }

    /**
     * @return string
     */
    public function getVariableName()
    {
        return 'entityManager';
    }

    /**
     * @return string
     */
    public function getCreateInstance()
    {
        return '$serviceManager->get(\'doctrine.entitymanager.orm_default\');';
    }

    /**
     * @param DataObject $dataobject
     * @return string
     */
    public function getQueryFindOneBy(DataObject $dataObject)
    {
        return '$result = $this->' . $this->getVariableName() . '->getRepository(\'' . $dataObject->getEntity() .
                '\')->findOneBy(array("id" => $' . lcfirst($dataObject->getEntityName()) . '->getId()));';
    }

    /**
     * @param DataObject $dataobject
     * @return string
     */
    public function getQueryFindAll(DataObject $dataObject)
    {
        return '$this->' . $this->getVariableName() . '->getRepository(\'' . $dataObject->getEntity() . '\')->findAll();';
    }

    /**
     * @return string
     */
    public function getModifyQuery()
    {
        return '$this->' . $this->getVariableName() . '->persist($entity);
        $this->' . $this->getVariableName() . '->flush();';
    }

    /**
     * @return string
     */
    public function getPersistQuery(DataObject $dataObject)
    {
        return '$this->' . $this->getVariableName() . '->persist($entity);
        $this->' . $this->getVariableName() . '->flush();';
    }

    /**
     * @return string
     */
    public function getRemoveQuery()
    {
        return '$this->' . $this->getVariableName() . '->remove($entity);
        $this->' . $this->getVariableName() . '->flush();';
    }
}