<?php
/**
 * GMCount plugin for Craft CMS 3.x
 *
 * @link      www.goodmotion.fr
 * @copyright Copyright (c) 2018 Faramaz Pat
 */

namespace goodmotion\gmcount\services;

use goodmotion\gmcount\GMCount;
use goodmotion\gmcount\records\GMCountRecord;
use craft\Elements\Entry;
use Craft;
use craft\db\Query;
use craft\base\Component;
use craft\helpers\Db;

/**
 *
 * @author    Faramaz Pat
 * @package   GMComment
 * @since     1.0.0
 */
class GMCountService extends Component
{

    /**
     * find record in table
     *
     * @param integer $entryId
     * @return GMCountRecord|null
     */
    private function findByEntryId(int $entryId): ?GMCountRecord
    {
        return GMCountRecord::findOne([
            'entry_id' => $entryId
        ]);
    }

    /**
     * incremente count for entry_id
     * @param int $entryId
     *
     * @return GMCountRecord
     */
    public function increment(int $entryId): GMCountRecord
    {
        // find if exist line for this entry
        $count = $this->findByEntryId($entryId);

        // if not exist
        if ($count === null) {
            $count = new GMCountRecord();
            $count->total = 0;
            $count->entry_id = $entryId;
        }
        // increment
        $count->total += 1;
        $count->save();

        return $count;
    }


    /**
     * Returns the count read by entry_id.
     * @param int $entryId
     *
     * @return GMCountRecord
     */
    public function count(int $entryId): int
    {
        // find line for this entry
        $count = $this->findByEntryId($entryId);

        // return total
        return $count->total;
    }


    /**
     * get entry by order for section id
     *
     * @param integer $sectionId
     * @param integer $limit
     * @return void
     */
    public function entriesBySection(int $sectionId, int $limit = 5): array
    {
        $en =  GMCountRecord::find()
        ->joinWith(['entry'])
        ->where(['IN', 'sectionId', $sectionId])
        ->orderBy('total DESC')
        ->limit($limit)
        ->all();

        $entries = [];
        foreach ($en as $entry) {
            $entries[] = Craft::$app->entries->getEntryById($entry->entry_id);
        }

        return $entries;
    }
}
