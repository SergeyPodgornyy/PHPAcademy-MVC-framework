<?php

namespace Model\Driver;

use PDO;

/**
 * This class extends native PDO one but allow nested transactions
 * by using the SQL statements `SAVEPOINT', 'RELEASE SAVEPOINT' AND 'ROLLBACK SAVEPOINT'
 */
class TransactionPDO extends PDO
{

    /**
    * @var array Database drivers that support SAVEPOINT * statements.
    */
    protected static $supportedDrivers = array("pgsql", "mysql");

    /**
    * @var int the current transaction depth
    */
    protected $transactionDepth = 0;


    /**
    * Test if database driver support savepoints
    *
    * @return bool
    */
    protected function hasSavepoint()
    {
        return in_array($this->getAttribute(PDO::ATTR_DRIVER_NAME), self::$supportedDrivers);
    }


    /**
    * Start transaction
    *
    * @return bool|void
    */
    public function beginTransaction()
    {
        if ($this->transactionDepth == 0 || !$this->hasSavepoint()) {
            parent::beginTransaction();
        } else {
            $this->exec("SAVEPOINT LEVEL{$this->transactionDepth}");
        }

        $this->transactionDepth++;
    }

    /**
    * Commit current transaction
    *
    * @return bool|void
    */
    public function commit()
    {
        $this->transactionDepth--;

        if ($this->transactionDepth == 0 || !$this->hasSavepoint()) {
            parent::commit();
        } else {
            $this->exec("RELEASE SAVEPOINT LEVEL{$this->transactionDepth}");
        }
    }

    /**
    * Rollback current transaction,
    *
    * @throws PDOException if there is no transaction started
    * @return bool|void
    */
    public function rollBack()
    {
        if ($this->transactionDepth == 0) {
            throw new \PDOException('Rollback error : There is no transaction started');
        }

        $this->transactionDepth--;

        if ($this->transactionDepth == 0 || !$this->hasSavepoint()) {
            parent::rollBack();
        } else {
            $this->exec("ROLLBACK TO SAVEPOINT LEVEL{$this->transactionDepth}");
        }
    }
}
