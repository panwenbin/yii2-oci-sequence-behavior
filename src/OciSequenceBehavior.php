<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\oci\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class OciSequenceBehavior
 *
 * Usage: Add this behavior to oci ActiveRecord model
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => OciSequenceBehavior::className(),
 *             'sequenceName' => 'SOME_SEQ',
 *         ],
 *     ];
 * }
 *
 *
 * @package common\behaviors
 */
class OciSequenceBehavior extends Behavior
{
    /* @var String */
    public $sequenceName;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'useSequence',
        ];
    }

    /**
     * @param $event
     */
    public function useSequence($event)
    {
        /* @var \yii\db\ActiveRecord $owner */
        $owner = $this->owner;
        if ($owner->isNewRecord) {
            if (empty($this->sequenceName)) {
                $tableName = $owner::getDb()->schema->getRawTableName($owner::tableName());
                $this->sequenceName = $tableName . '_SQ';
            }
            if (count($owner::primaryKey()) == 1) {
                $pk = $owner::primaryKey()[0];
                if (empty($owner->$pk)) {
                    $nextVal = $owner::getDb()->createCommand("SELECT {$this->sequenceName}.NEXTVAL FROM DUAL")->queryScalar();
                    $owner->$pk = $nextVal;
                }
            }
        }
    }
}