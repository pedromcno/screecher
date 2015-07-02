<?php

namespace Screecher\Repository;

use Doctrine\DBAL\Connection;
use Screecher\Entity\Maintainer;

/**
 * Maintainer repository
 */
class MaintainerRepository
{
    /**
     * @var Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Saves a maintainer to the database.
     *
     * @param array $maintainerData
     * @return array
     */
    public function save($maintainerData)
    {
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
     * @return Maintainer[] Collection.
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
     * @return Maintainer
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