## Database Utility @method Exec uses

```php
<?php
// array
$scheme = [
    'tableName' => [ # string table name
        /* ------------------------------------
         * COLUMNS DEFINITIONS
         * --------------------------------- */
        'columns' => [
            'columnName' => [             # string colum name 
                'type' => 'bigint',       # string type (Doctrine\DBAL\Types)
                'options' => [
                    // example uses for (Doctrine\DBAL\Schema\Column)
                    'autoincrement' => 1, # ->setIncrement(1)
                    'length' => 10        # ->setLength(1)
                ]
            ],
            // ... next
        ],
    
        /* ------------------------------------
         * TABLE PROPERTIES
         * --------------------------------- */
        'properties' => [
            // @see Doctrine\DBAL\Schema\Table ->set..NameOfProperty..
            'primaryKey' => ['id'],
        ]
    ],
];

/** 
 * @uses Pentagonal\SlimHelper\Utilities\DatabaseUtility::execSchema($scheme, \Interop\Container\ContainerInterface $container);
 */
```