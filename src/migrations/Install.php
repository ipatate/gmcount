<?php
/**
 * GMCount plugin for Craft CMS 3.x
 *
 *
 * @link      www.goodmotion.fr
 * @copyright Copyright (c) 2018 Faramaz Pat
 */

namespace goodmotion\gmcount\migrations;

use goodmotion\gmcount\GMCount;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 *
 * If you need to perform any additional actions on install/uninstall, override the
 * safeUp() and safeDown() methods.
 *
 * @author    Faramaz Pat
 * @package   GMComment
 * @since     1.0.0
 */
class Install extends Migration
{
    /**
     * @var string The database driver to use
     */
    public $driver;

    /**
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeUp(): boolean
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

    /**
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }


    /**
     * Creates the tables needed for the Records used by the plugin
     *
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        // gmcount table
        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%gmcount}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%gmcount}}',
                [
                    'id' => $this->primaryKey(),
                    'total' => $this->integer()->notNull(),
                    'entry_id' => $this->integer()->notNull(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * Creates the indexes needed for the Records used by the plugin
     *
     * @return void
     */
    protected function createIndexes()
    {
        // add index in is_approved for filter
        $this->createIndex(
            $this->db->getIndexName(
                '{{%gmcount}}',
                'entry_id'
            ),
            '{{%gmcount}}',
            'entry_id'
        );

        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * Creates the foreign keys needed for the Records used by the plugin
     *
     * @return void
     */
    protected function addForeignKeys()
    {
    }

    /**
     * Populates the DB with the default data.
     *
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * Removes the tables needed for the Records used by the plugin
     *
     * @return void
     */
    protected function removeTables()
    {
        // gmcount table
        $this->dropTableIfExists('{{%gmcount}}');
    }
}
