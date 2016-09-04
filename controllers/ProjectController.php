<?php

namespace app\controllers;

use yii;
use app\components\Controller;
use app\components\Repo;
use app\components\Folder;
use app\components\CodeFile;
use app\models\Task;
use app\models\Project;
use app\models\Group;

class ProjectController extends Controller {


    /**
     * 获取文件列表
     *
     * @param $projectId 没有projectId则显示列表
     * @return string
     */
    public function actionFilelist($projectId, $commitId = '', $dir = '.') {
        \Yii::$app->response->format = 'json';

        $project = Project::getConf($projectId);
        if (!$project) {
            throw new \Exception(yii::t('task', 'unknown project'));
        }

        $files = $project->getFiles($commitId, $dir);

        return ['data' => $files];
    }

    public function actionFilediff($projectId, $file)
    {
        \Yii::$app->response->format = 'json';
        $project = Project::getConf($projectId);
        if (!$project) {
            throw new \Exception(yii::t('task', 'unknown project'));
        }

        return (new CodeFile($project))->diffWithOnline($file);

    }
}
