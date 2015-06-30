<?php

namespace Screecher\Repository;

use Doctrine\DBAL\Connection;
use Screecher\Entity\Api;

/**
 * Api repository
 */
class ApiRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Returns an api matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Screecher\Entity\Api|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $apiData = $this->db->fetchAssoc('SELECT * FROM apis WHERE id = ?', array($id));
        return $apiData ? $this->buildApi($apiData) : FALSE;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $apisData = $this->db->fetchAll('SELECT * FROM apis');

        $apiCollection = [];

        foreach ($apisData as $apiData) {
           $apiCollection[] = $this->buildApi($apiData);
        }

        return $apiCollection;
    }

    /**
     * @param $arrayNames
     * @return array
     */
    public function findAllByNames($arrayNames)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->add('where', $qb->expr()->in('a.name', ':array_names'))
            ->select('*')
            ->from('apis', 'a')
            ->innerJoin('a', 'maintainers', 'm', 'm.api_id = a.id')
            ->setParameter('array_names', $arrayNames, Connection::PARAM_STR_ARRAY);

        $statement = $qb->execute();
        $apiData = $statement->fetchAll();

        if (!empty($apiData)) {
            $formattedApiData = [];
            foreach ($apiData as $item) {
                $formattedApiData[$item['name']][] = $item['email'];
            }

            return $formattedApiData;
        }

        return $apiData;
    }

    /**
     * Instantiates an api entity and sets its properties using db data.
     *
     * @param array $apiData
     *   The array of db data.
     *
     * @return \Screecher\Entity\Api
     */
    protected function buildApi($apiData)
    {
        $api = new Api();
        $api->setId($apiData['id']);
        $api->setName($apiData['name']);
        return $api;
    }
}