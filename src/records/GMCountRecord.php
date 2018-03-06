<?php
/**
 * GMCount plugin for Craft CMS 3.x
 *
 *
 * @link      www.goodmotion.fr
 * @copyright Copyright (c) 2018 Faramaz Pat
 */

namespace goodmotion\gmcount\records;

use goodmotion\gmcount\GMCount;

use Craft;
use craft\records\Entry;
use craft\db\ActiveRecord;

/**
 *
 * @author    Faramaz Pat
 * @package   GMComment
 * @since     1.0.0
 */
class GMCountRecord extends ActiveRecord
{
    /**
     * entry relation
     *
     * @return void
     */
    public function getEntry()
    {
        return $this->hasOne(Entry::class, ['id' => 'entry_id']);
    }

    /**
     *
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{%gmcount}}';
    }
}
