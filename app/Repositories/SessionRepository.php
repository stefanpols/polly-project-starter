<?php

namespace App\Repositories;

use App\Models\Session;
use Polly\Interfaces\IDatabaseConnection;
use Polly\ORM\EntityRepository;
use Polly\ORM\QueryBuilder;

class SessionRepository extends EntityRepository
{
    public function __construct(IDatabaseConnection $connection)
    {
        parent::__construct(Session::class, $connection);
    }

    /**
     * @return Session|null
     */
    public function findByToken(string $token) : ?Session
    {
        $queryBuilder = (new QueryBuilder())
            ->table($this->getTableName())
            ->select()
            ->single()
            ->where($this->getColumnName('token'), $token);

        return $this->execute($queryBuilder);
    }

}
