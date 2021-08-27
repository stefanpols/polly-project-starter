<?php

namespace App\Repositories;

use App\Models\User;
use Polly\Interfaces\IAuthenticationModel;
use Polly\Interfaces\IDatabaseConnection;
use Polly\ORM\AbstractEntity;
use Polly\ORM\EntityRepository;
use Polly\ORM\QueryBuilder;

class UserRepository extends EntityRepository
{
    public function __construct(IDatabaseConnection $connection)
    {
        parent::__construct(User::class, $connection);
    }

    /**
     * @return User[]
     */
    public function all() : array
    {
        $queryBuilder = (new QueryBuilder())
            ->table($this->getTableName())
            ->select()
            ->where($this->getColumnName('active'), 1);

        return $this->execute($queryBuilder);
    }

    /**
     * @param AbstractEntity $entity
     * @return bool
     */
    public function delete(AbstractEntity $entity) : bool
    {
        $queryBuilder = (new QueryBuilder())
            ->table($this->getTableName())
            ->update()
            ->value($this->getColumnName('active'), '0')
            ->where($this->getColumnName($this->getPrimaryKey()), $entity->getId());

        return $this->execute($queryBuilder);
    }

    /**
     * @return IAuthenticationModel|null
     */
    public function findByUsername(string $username) : ?IAuthenticationModel
    {
        $queryBuilder = (new QueryBuilder())
            ->table($this->getTableName())
            ->select()
            ->single()
            ->where($this->getColumnName('active'), 1)
            ->where($this->getColumnName('username'), $username);

        return $this->execute($queryBuilder);
    }


}
