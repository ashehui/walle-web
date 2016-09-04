<?php
/* *****************************************************************
 * @Author: wushuiyong
 * @Created Time : 五  7/31 22:21:23 2015
 *
 * @File Name: command/Folder.php
 * @Description:
 * *****************************************************************/
namespace app\components;

use Yii;

class CodeFile extends Command {

    public function diffWithOnline($file) {
        $localSourceDir = $this->config->getDeployFromDir(); 
        $remoteSourceDir = $this->config->getTargetWorkspace();

        $cmd[] = "cat {$remoteSourceDir}/{$file}";
        $command = implode(' && ', $cmd);

        $host = GlobalHelper::str2arr($this->config->hosts)[0];

        if ($this->runRemoteCommand($command, 0, $host)) {
            $contentOld = explode(PHP_EOL, substr($this->log, strlen($host . ' : ')));
            array_walk($contentOld, function(&$line) {
                $line = rtrim($line, "\r\n");
            });
        } else {
            $contentOld = [];
        }
        $contentNew = file("{$localSourceDir}/{$file}");
        array_walk($contentNew, function(&$line) {
            $line = rtrim($line, "\r\n");
        });
        $diff = new \Diff($contentOld, $contentNew);
        return $diff->render(new \Diff_Renderer_Html_Array);
    }

}

