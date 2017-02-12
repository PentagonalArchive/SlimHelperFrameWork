<?php
namespace Pentagonal\SlimHelper;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\View;

/**
 * Class Database
 * @package Nat
 *
 * Magic Method @see Database::__call()
 *      -> @uses Connection
 *
 * @method void beginTransaction()
 *
 * @method void         close()
 * @method void         commit()
 * @method bool         connect()
 * @method mixed        convertToDatabaseValue(mixed $value, $type)
 * @method mixed        convertToPHPValue(mixed $value, $type)
 * @method QueryBuilder createQueryBuilder()
 * @method void         createSavepoint(string $savepoint)
 *
 * @method int delete(string $tableExpression, array $identifier, array $types = [])
 *
 * @method int       errorCode()
 * @method array     errorInfo()
 * @method void      exec(string $statement)
 * @method Statement executeQuery(string $query, array $params = [], array $types = [], QueryCacheProfile $qcp = null)
 * @method ResultStatement executeCacheQuery(string $query, $params, $types, QueryCacheProfile $qcp)
 * @method int       executeUpdate(string $query, array $params = [], array $types = [])
 *
 * @method int  insert(string $tableExpression, array $data, array $types = [])
 * @method bool isAutoCommit()
 * @method bool isConnected()
 * @method bool isRollbackOnly()
 * @method bool isTransactionActive()
 *
 * @method array fetchAssoc(string $statement, array $params = [], array $types = [])
 * @method array fetchArray(string $statement, array $params = [], array $types = [])
 * @method array fetchColumn(string $statement, array $params = [], array $types = [])
 * @method array fetchAll(string $sql, array $params = array(), $types = array())
 *
 * @method Configuration         getConfiguration()
 * @method Driver                getDriver()
 * @method string                getDatabase()
 * @method AbstractPlatform      getDatabasePlatform()
 * @method EventManager          getEventManager()
 * @method ExpressionBuilder     getExpressionBuilder()
 * @method string                getHost()
 * @method array                 getParams()
 * @method string|null           getPassword()
 * @method mixed                 getPort()
 * @method AbstractSchemaManager getSchemaManager()
 * @method int                   getTransactionIsolation()
 * @method int                   getTransactionNestingLevel()
 * @method string|null           getUsername()
 * @method Connection            getWrappedConnection()
 *
 * @method string lastInsertId(string|null $seqName)
 *
 * @method bool      ping()
 * @method Statement prepare(string $statement)
 * @method array     project(string $query, array $params, \Closure $function)
 *
 * @method void      releaseSavepoint(string $savePoint)
 * @method array     resolveParams(array $params, array $types)
 * @method bool|void rollBack()
 * @method void      rollbackSavepoint(string $savePoint)
 *
 * @method void setAutoCommit(bool $autoCommit)
 * @method void setFetchMode(int $fetchMode)
 * @method void setNestTransactionsWithSavePoints(bool $nestTransactionsWithSavePoints)
 * @method void setRollbackOnly()
 * @method int  setTransactionIsolation(int $level)
 *
 * @method void transactional(\Closure $func)
 *
 * @method int update(string $tableExpression, array $data, array $identifier, array $types = [])
 *
 * @method string    quote(mixed $input, int $type = \PDO::PARAM_STR)
 * @method string    quoteIdentifier(string $str)
 *
 * @uses \PDO::ATTR_DEFAULT_FETCH_MODE for (19)
 * @method Statement query(string $sql, int $mode = 19, mixed $additionalArg = null, array $constructorArgs = [])
 */
class Database
{
    /**
     * @see Connection::TRANSACTION_READ_UNCOMMITTED
     */
    const TRANSACTION_READ_UNCOMMITTED = Connection::TRANSACTION_READ_UNCOMMITTED;

    /**
     * @see Connection::TRANSACTION_READ_COMMITTED
     */
    const TRANSACTION_READ_COMMITTED   = Connection::TRANSACTION_READ_COMMITTED;

    /**
     * @see Connection::TRANSACTION_REPEATABLE_READ
     */
    const TRANSACTION_REPEATABLE_READ = Connection::TRANSACTION_REPEATABLE_READ;

    /**
     * @see Connection::TRANSACTION_SERIALIZABLE
     */
    const TRANSACTION_SERIALIZABLE = Connection::TRANSACTION_SERIALIZABLE;

    /**
     * @see Connection::PARAM_INT_ARRAY
     */
    const PARAM_INT_ARRAY = Connection::PARAM_INT_ARRAY;

    /**
     * @see Connection::PARAM_STR_ARRAY
     */
    const PARAM_STR_ARRAY = Connection::PARAM_STR_ARRAY;

    /**
     * @see Connection::ARRAY_PARAM_OFFSET
     */
    const ARRAY_PARAM_OFFSET = Connection::ARRAY_PARAM_OFFSET;

    /**
     * @var Connection
     */
    protected $currentConnection;

    /**
     * @var string
     */
    protected $currentSelectedDriver;

    /**
     * @var array
     */
    protected $currentUserParams = [
        'charset' => 'UTF8',
        'collate' => 'utf_general_ci'
    ];

    /**
     * @var string
     */
    protected $currentTablePrefix = '';

    /**
     * Column Quote Identifier
     *
     * @var string
     */
    protected $currentQuoteIdentifier = '"';

    /**
     * Database constructor.
     * @param array $configs database Configuration
     * @throws DBALException
     */
    public function __construct(array $configs)
    {
        /**
         * Merge User Param
         */
        $this->currentUserParams = array_merge($this->currentUserParams, $configs);
        if (!isset($this->currentUserParams['db.driver'])) {
            throw new DBALException('Driver must be declare.', E_USER_ERROR);
        }
        if (! is_string($this->currentUserParams['db.driver'])) {
            throw new DBALException('Driver must as a string.', E_USER_ERROR);
        }

        /**
         * Sanitize Selected Driver
         */
        $this->currentSelectedDriver = $this
            ->sanitizeSelectedAvailableDriver($this->currentUserParams['db.driver']);
        if (!$this->currentSelectedDriver) {
            throw new DBALException('Selected driver unavailable.', E_USER_ERROR);
        }

        if (isset($this->currentUserParams['db.prefix']) && is_string($this->currentUserParams['db.prefix'])) {
            $this->currentUserParams['db.prefix'] = trim($this->currentUserParams['db.prefix']);
            $this->currentTablePrefix = (string) $this->currentUserParams['db.prefix'];
        }

        if ($this->currentSelectedDriver == 'pdo_sqlite' && !isset($this->currentUserParams['db.path'])) {
            if (!isset($this->currentUserParams['db.name']) || !is_string($this->currentUserParams['db.name'])) {
                throw new DBALException('SQLite database path must be not empty.', E_USER_ERROR);
            }
            $this->currentUserParams['db.path'] = $this->currentUserParams['db.name'];
        }

        /**
         * create new parameters
         */
        $this->currentUserParams['driver'] = $this->currentSelectedDriver;
        if (isset($this->currentUserParams['db.user'])) {
            $this->currentUserParams['user'] = $this->currentUserParams['db.user'];
        }
        if (isset($this->currentUserParams['db.pass'])) {
            $this->currentUserParams['password'] = $this->currentUserParams['db.pass'];
        }
        if (isset($this->currentUserParams['db.path'])) {
            $this->currentUserParams['path'] = $this->currentUserParams['db.path'];
        }

        foreach ($this->currentUserParams as $key => $db) {
            unset($this->currentUserParams[$key]);
            if (in_array($key, ['db.prefix', 'db.path', 'db.user', 'db.pass'])) {
                continue;
            }
            $key = str_replace('db.', 'db', $key);
            $this->currentUserParams[$key] = $db;
        }

        /**
         * Create New Connection
         */
        $this->currentConnection = DriverManager::getConnection($this->currentUserParams);

        /**
         * Set Quote Identifier
         */
        $this->currentQuoteIdentifier = $this->
            currentConnection
            ->getDatabasePlatform()
            ->getIdentifierQuoteCharacter();
    }

    /**
     * Getting Doctrine Connection
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->currentConnection;
    }

    /**
     * Get Table Prefix
     *
     * @return string
     */
    public function getTablePrefix()
    {
        return $this->currentTablePrefix;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getQuoteIdentifier()
    {
        return $this->currentQuoteIdentifier;
    }

    /**
     * Get user params
     *
     * @return array
     */
    public function getUserParams()
    {
        return $this->currentUserParams;
    }

    /**
     * Get Connection params
     *
     * @return array
     */
    public function getConnectionParams()
    {
        return $this->getParams();
    }

    /**
     * Check Database driver available for Doctrine
     * and choose the best driver of sqlsrv an oci
     *
     * @param string $driverName
     * @final
     * @return bool|string return lowercase an fix database driver for Connection
     */
    final public function sanitizeSelectedAvailableDriver($driverName)
    {
        if (is_string($driverName) && trim($driverName)) {
            $driverName = trim(strtolower($driverName));
            /**
             * switch to Doctrine fixed db
             * Aliases
             */
            $driverSchemeAliases = [
                'db2'        => 'ibm_db2',
                'drizzle'    => 'drizzle_pdo_mysql',
                'mssql'      => 'pdo_sqlsrv',
                'mysql'      => 'pdo_mysql',
                'mysql2'     => 'pdo_mysql', // Amazon RDS, for some weird reason
                'postgre'    => 'pdo_pgsql',
                'postgre_sql'=> 'pdo_pgsql',
                'postgres'   => 'pdo_pgsql',
                'postgresql' => 'pdo_pgsql',
                'pgsql'      => 'pdo_pgsql',
                'sqlite'     => 'pdo_sqlite',
                'sqlite3'    => 'pdo_sqlite',
                'oci'        => 'oci8',
                'pdo_oci'    => 'oci8',   # recommendation pdo_oci uses oci8
                'pdo_sqlsrv' => 'sqlsrv', #recommendation pdo_sqlsrv uses sqlsrv
            ];
            if (isset($driverSchemeAliases[$driverName])) {
                $driverName = $driverSchemeAliases[$driverName];
            }
            if (in_array($driverName, DriverManager::getAvailableDrivers())) {
                return $driverName;
            }
        }

        return false;
    }

    /**
     * Trimming table for safe usage
     *
     * @param mixed $table
     * @return mixed
     */
    public function trimTableSelector($table)
    {
        if (is_array($table)) {
            foreach ($table as $key => $value) {
                $table[$key] = $this->trimTableSelector($value);
            }
            return $table;
        } elseif (is_object($table)) {
            foreach (get_object_vars($table) as $key => $value) {
                $table->{$key} = $this->trimTableSelector($value);
            }
            return $table;
        }
        if (is_string($table)) {
            $tableArray = explode('.', $table);
            foreach ($tableArray as $key => $value) {
                $tableArray[$key] = trim(
                    trim(
                        trim($value),
                        $this->currentQuoteIdentifier
                    )
                );
            }
            $table = implode('.', $tableArray);
        }

        return $table;
    }

    /**
     * Alternative multi variable type quoted identifier
     *
     * @param mixed $quoteStr
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function quoteIdentifiers($quoteStr)
    {
        if ($quoteStr instanceof \Closure || is_resource($quoteStr)) {
            throw new \InvalidArgumentException(
                "Invalid value to be quote, quote value could not be instance of `Closure` or as a `Resource`",
                E_USER_ERROR
            );
        }

        $quoteStr = $this->trimTableSelector($quoteStr);
        if (is_array($quoteStr)) {
            foreach ($quoteStr as $key => $value) {
                $quoteStr[$key] = $this->quoteIdentifiers($value);
            }
            return $quoteStr;
        } elseif (is_object($quoteStr)) {
            foreach (get_object_vars($quoteStr) as $key => $value) {
                $quoteStr->{$key} = $this->quoteIdentifiers($value);
            }
            return $quoteStr;
        }

        $return = $this->quoteIdentifier($quoteStr);

        return $return;
    }

    /**
     * Alternative multi variable type quote string
     *      Nested quotable
     *
     * @param mixed $quoteStr
     * @param int   $type
     * @return array|mixed|string
     */
    public function quotes($quoteStr, $type = \PDO::PARAM_STR)
    {
        if ($quoteStr instanceof \Closure || is_resource($quoteStr)) {
            throw new \InvalidArgumentException(
                "Invalid value to be quote, quote value could not be instance of `Closure` or as a `Resource`",
                E_USER_ERROR
            );
        }

        $quoteStr = $this->trimTableSelector($quoteStr);
        if (is_array($quoteStr)) {
            foreach ($quoteStr as $key => $value) {
                $quoteStr[$key] = $this->quotes($value, $type);
            }
            return $quoteStr;
        } elseif (is_object($quoteStr)) {
            foreach (get_object_vars($quoteStr) as $key => $value) {
                $quoteStr->{$key} = $this->quotes($value, $type);
            }
            return $quoteStr;
        }

        return $this->quote($quoteStr);
    }

    /**
     * Prefix CallBack
     *
     * @access private
     * @param  string $table the table
     * @return string
     */
    private function prefixTableCallback($table)
    {
        $prefix = $this->getTablePrefix();
        if (!empty($prefix) && is_string($prefix) && trim($prefix)) {
            $table = (strpos($table, $prefix) === 0)
                ? $table
                : $prefix.$table;
        }

        return $table;
    }

    /**
     * Prefixing table with predefined table prefix on configuration
     *
     * @param mixed $table
     * @param bool  $use_identifier
     * @return array|null|string
     */
    public function prefixTables($table, $use_identifier = false)
    {
        if ($table instanceof \Closure || is_resource($table)) {
            throw new \InvalidArgumentException(
                "Invalid value to be quote, table value could not be instance of `Closure` or as a `Resource`",
                E_USER_ERROR
            );
        }

        $prefix = $this->getTablePrefix();
        if (is_array($table)) {
            foreach ($table as $key => $value) {
                $table[$key] = $this->prefixTables($value, $use_identifier);
            }
            return $table;
        }
        if (is_object($table)) {
            foreach (get_object_vars($table) as $key => $value) {
                $table->{$key} = $this->prefixTables($value, $use_identifier);
            }
            return $table;
        }
        if (!is_string($table)) {
            return null;
        }
        if (strpos($table, $this->currentQuoteIdentifier) !== false) {
            $use_identifier = true;
        }
        if (!empty($prefix) && is_string($prefix) && trim($prefix)) {
            $tableArray = explode('.', $table);
            $tableArray    = $this->trimTableSelector($tableArray);
            if (count($tableArray) > 1) {
                $connectionParams = $this->getConnectionParams();
                if (isset($connectionParams['db.name']) && $tableArray[0] == $connectionParams['db.name']) {
                    $tableArray[1] = $this->prefixTableCallback($tableArray);
                }
                if ($use_identifier) {
                    return $this->currentQuoteIdentifier
                        . implode("{$this->currentQuoteIdentifier}.{$this->currentQuoteIdentifier}", $tableArray)
                        . $this->currentQuoteIdentifier;
                } else {
                    return implode(".", $tableArray);
                }
            } else {
                $table = $this->prefixTableCallback($tableArray[0]);
            }
        }

        return $use_identifier
            ? $this->currentQuoteIdentifier.$table.$this->currentQuoteIdentifier
            : $table;
    }

    /**
     * @uses Database::prefixTables()
     *
     * @param mixed $tables
     * @param bool  $use_identifier
     * @return mixed
     */
    public function prefix($tables, $use_identifier = false)
    {
        return $this->prefixTables($tables, $use_identifier);
    }

    /**
     * Compile Bindings
     *     Take From CI 3 Database Query Builder, default string Binding use Question mark ( ? )
     *
     * @param   string $sql   sql statement
     * @param   array  $binds array of bind data
     * @return  mixed
     */
    public function compileBindsQuestionMark($sql, $binds = null)
    {
        if (empty($binds) || strpos($sql, '?') === false) {
            return $sql;
        } elseif (! is_array($binds)) {
            $binds = [$binds];
            $bind_count = 1;
        } else {
            // Make sure we're using numeric keys
            $binds = array_values($binds);
            $bind_count = count($binds);
        }
        // Make sure not to replace a chunk inside a string that happens to match the bind marker
        if ($countMatches = preg_match_all("/'[^']*'/i", $sql, $matches)) {
            $countMatches = preg_match_all(
                '/\?/i', # regex
                str_replace(
                    $matches[0],
                    str_replace('?', str_repeat(' ', 1), $matches[0]),
                    $sql,
                    $countMatches
                ),
                $matches, # matches
                PREG_OFFSET_CAPTURE
            );
            // Bind values' count must match the count of markers in the query
            if ($bind_count !== $countMatches) {
                return false;
            }
        } elseif (($countMatches = preg_match_all('/\?/i', $sql, $matches, PREG_OFFSET_CAPTURE)) !== $bind_count) {
            return $sql;
        }

        do {
            $countMatches--;
            $escapedValue = is_int($binds[$countMatches])
                ? $binds[$countMatches]
                : $this->quote($binds[$countMatches]);
            if (is_array($escapedValue)) {
                $escapedValue = '('.implode(',', $escapedValue).')';
            }
            $sql = substr_replace($sql, $escapedValue, $matches[0][$countMatches][1], 1);
        } while ($countMatches !== 0);

        return $sql;
    }

    /**
     * Query using binding optionals statements
     *
     * @uses   compileBindsQuestionMark
     * @param  string $sql
     * @param  mixed  $statement array|string|null
     * @return Statement
     * @throws DBALException
     */
    public function queryBind($sql, $statement = null)
    {
        $sql = $this->compileBindsQuestionMark($sql, $statement);
        if ($sql === false) {
            throw new DBALException(
                sprintf(
                    'Invalid statement binding count with sql query : %s',
                    $sql
                ),
                E_USER_WARNING
            );
        }

        return $this->query($sql);
    }

    /**
     * --------------------------------------------------------------
     * SCHEMA
     *
     * Lists common additional Methods just for check & lists only
     * to use more - please @uses Database::getSchemaManager()
     *
     * @see AbstractSchemaManager
     *
     * ------------------------------------------------------------ */

    /**
     * Check Table Maybe Invalid
     *
     * @param string $tableName
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function tableMaybeInvalid($tableName)
    {
        if (!is_string($tableName)) {
            throw new \InvalidArgumentException(
                'Invalid table name type. Table name must be as string',
                E_USER_ERROR
            );
        }

        $tableName = trim($tableName);
        if ($tableName == '') {
            throw new \InvalidArgumentException(
                'Invalid parameter table name. Table name could not be empty.',
                E_USER_ERROR
            );
        }

        return $tableName;
    }

    /**
     * Get List Available Databases
     *
     * @return array
     */
    public function listDatabases()
    {
        return $this->getSchemaManager()->listDatabases();
    }

    /**
     * Returns a list of all namespaces in the current database.
     *
     * @return array
     */
    public function listNamespaceNames()
    {
        return $this->getSchemaManager()->listDatabases();
    }

    /**
     * Lists the available sequences for this connection.
     *
     * @return Sequence[]
     */
    public function listSequences()
    {
        return $this->getSchemaManager()->listSequences();
    }

    /**
     * Get Doctrine Column of table
     *
     * @param string $tableName
     * @return Column[]
     */
    public function listTableColumns($tableName)
    {
        $tableName = $this->tableMaybeInvalid($tableName);
        return $this
            ->getSchemaManager()
            ->listTableColumns($tableName);
    }

    /**
     * Lists the indexes for a given table returning an array of Index instances.
     *
     * Keys of the portable indexes list are all lower-cased.
     *
     * @param string $tableName The name of the table.
     *
     * @return Index[]
     */
    public function listTableIndexes($tableName)
    {
        $tableName = $this->tableMaybeInvalid($tableName);
        return $this
            ->getSchemaManager()
            ->listTableIndexes($tableName);
    }

    /**
     * Check if table is Exists
     *
     * @param string $tables
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function tablesExist($tables)
    {
        if (! is_string($tables) && !is_array($tables)) {
            throw new \InvalidArgumentException(
                'Invalid table name type. Table name must be as string or array',
                E_USER_ERROR
            );
        }

        $tables = $this->prefixTables($tables);
        ! is_array($tables) && $tables = [$tables];
        return $this
            ->getSchemaManager()
            ->tablesExist($tables);
    }

    /**
     * Returns a list of all tables in the current Database Connection.
     *
     * @return array
     */
    public function listTableNames()
    {
        return $this
            ->getSchemaManager()
            ->listTableNames();
    }

    /**
     * Get List Table
     *
     * @return Table[]
     */
    public function listTables()
    {
        return $this
            ->getSchemaManager()
            ->listTables();
    }

    /**
     * Get Object Doctrine Table from Table Name
     *
     * @param string $tableName
     *
     * @return Table
     */
    public function listTableDetails($tableName)
    {
        $tableName = $this->tableMaybeInvalid($tableName);
        return $this->getSchemaManager()->listTableDetails($tableName);
    }

    /**
     * Lists the views this connection has.
     *
     * @return View[]
     */
    public function listViews()
    {
        return $this->getSchemaManager()->listViews();
    }

    /**
     * Lists the foreign keys for the given table.
     *
     * @param string      $tableName    The name of the table.
     *
     * @return ForeignKeyConstraint[]
     */
    public function listTableForeignKeys($tableName)
    {
        $tableName = $this->tableMaybeInvalid($tableName);
        return $this->getSchemaManager()->listTableForeignKeys($tableName);
    }


    /**
     * Magic Method __call - calling arguments for backward compatibility
     *
     * @uses Connection
     *
     * @param string $method method object :
     *                       @see Connection
     * @param array  $arguments the arguments list
     * @return mixed
     * @throws DBALException
     */
    public function __call($method, array $arguments)
    {
        /**
         * check if method exists on connection @see Connection !
         */
        if (method_exists($this->getConnection(), $method)) {
            return call_user_func_array([$this->getConnection(), $method], $arguments);
        }
        throw new DBALException(
            sprintf(
                "Call to undefined Method %s",
                $method
            ),
            E_USER_ERROR
        );
    }
}
