<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Detail;

use Github\Client;
use Packagist\Api\Result\Result;

/**
 * Find all generator allow in project
 *
 * @author Stéphane Demonchaux
 */
class GeneratorDetail
{
    /**
     * @var Client
     */
    private $client = null;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Result $package
     * @return string
     */
    public function find(Result $package)
    {
        $repository     = str_replace('https://github.com/', '', $package->getRepository());
        $packageExplode = explode('/', $repository);

        $data = $this->client->api('repo')->contents()->readme($packageExplode[0], $packageExplode[1]);

        return array(
            'readme' => $this->client->api('markdown')->render(base64_decode($data['content'])),
            'github' => $package->getRepository()
        );
    }
}
