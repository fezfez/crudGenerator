<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use CrudGenerator\Command\CommandDefinition;

/**
 * Generator command
 *
 * @author St  phane Demonchaux
 */
class SkeletonCommand extends Command
{
    /**
     * @var CommandDefinition
     */
    private $commandDefinition = null;

    /**
     * @param CommandDefinition $commandDefinition
     */
    public function __construct(CommandDefinition $commandDefinition)
    {
        $this->commandDefinition = $commandDefinition;
        parent::__construct($this->commandDefinition->getAction());
    }
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName($this->commandDefinition->getNamespace() . ':' . $this->commandDefinition->getAction())
             ->setDescription($this->commandDefinition->getDefinition());
    }

    /* (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $runner = $this->commandDefinition->getRunner();
        $runner();
    }
}
