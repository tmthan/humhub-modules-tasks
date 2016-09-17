<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\tasks\widgets;

use Yii;

/**
 * Description of Task
 *
 * @author Luke
 */
class FilterSnippet extends \humhub\components\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        $timeFilters = [];
        $timeFilters['all'] = Yii::t('TasksModule.filters', 'All');
        $timeFilters['today'] = Yii::t('TasksModule.filters', 'Today');
        $timeFilters['week'] = Yii::t('TasksModule.filters', 'This week');
        $timeFilters['month'] = Yii::t('TasksModule.filters', 'This month');
        $timeFilters['unscheduled'] = Yii::t('TasksModule.filters', 'Unscheduled');

        $statusFilters = [];
        $statusFilters['active'] = 'Active';
        $statusFilters['completed'] = 'Completed';
        $statusFilters['deferred'] = 'Deferred';
        $statusFilters['cancelled'] = 'Cancelled';

        return $this->render('filterSnippet', [
                    'defaultFilter' => self::getDefaultFilter(),
                    'timeFilters' => $timeFilters,
                    'statusFilters' => $statusFilters,
        ]);
    }

    public static function getDefaultFilter()
    {
        $filters = [];
        try {
            $savedFilters = Yii::$app->getModule('tasks')->settings->user()->get('filters');
            if ($savedFilters != '') {
                $filters = \yii\helpers\Json::decode($savedFilters);
            }
        } catch (Exception $ex) {
            
        }

        if (!isset($filters['time'])) {
            $filters['time'] = 'all';
        }

        if (!isset($filters['status'])) {
            $filters['status'][] = 'active';
        }

        if (!isset($filters['showUnassigned'])) {
            $filters['showUnassigned'] = false;
        }

        if (!isset($filters['showFromOtherSpaces'])) {
            $filters['showFromOtherSpaces'] = false;
        }

        return $filters;
    }

}
