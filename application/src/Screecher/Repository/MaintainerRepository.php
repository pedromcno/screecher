<?php

namespace Screecher\Repository;

use Doctrine\DBAL\Connection;
use Screecher\Entity\Maintainer;

/**
 * Api repository
 */
class MaintainerRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * @var \Screecher\Repository\ApiRepository
     */
    //protected $apiRepository;

    public function __construct(Connection $db)
    {
        $this->db = $db;

        //$this->apiRepository = $apiRepository;
    }


    /**
     * Saves a maintainer to the database.
     *
     * @param \Screecher\Entity\Maintainer $maintainer
     * @return Maintainer
     */
    public function save($maintainerData)
    {
//        $maintainerData = array(
//            'email' => $maintainer->getEmail(),
//            'api_id' => $maintainer->getApi(),
//
//        );

        $this->db->insert('maintainers', $maintainerData);

        $id = $this->db->lastInsertId();
        $maintainerData['id'] = $id;

        return $maintainerData;
    }

    /**
     * Returns maintainers by api id.
     *
     * @param integer $id
     *
     * @return \Screecher\Entity\Maintainer[] Collection.
     */
    public function findAllByApi($id)
    {
        $maintainersData = $this->db->fetchAll('SELECT * FROM maintainers WHERE api_id = ?', array($id));

        $maintainersCollection = array();
        foreach ($maintainersData as $maintainerData) {
            $maintainersCollection[] = $maintainerData;
        }

        return $maintainersCollection;
    }


    /**
     * Instantiates a Maintainer entity and sets its properties using db data.
     *
     * @param array $maintainerData
     *   The array of db data.
     *
     * @return \Screecher\Entity\Maintainer
     */
    protected function buildMaintainer($maintainerData)
    {
        $maintainer = new Maintainer();
        $maintainer->setId($maintainerData['id']);
        $maintainer->setEmail($maintainerData['email']);
        $maintainer->setApi($maintainerData['api_id']);

        return $maintainer;
    }
}