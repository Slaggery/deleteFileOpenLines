<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("SM_SAFE_MODE", true);
define("NO_AGENT_CHECK", true);
define("NO_AGENT_STATISTIC", true);
define("STOP_STATISTICS", true);

$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/dev02/dev02.brogzy.ru";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$USER = new CUser;
$USER->Authorize(1);

CModule::IncludeModule("imopenlines");

$sessions = \Bitrix\Imopenlines\Model\SessionTable::getList(['select' => ['CHAT_ID', 'START_ID', 'END_ID']]);

foreach ($sessions as $session) {
    $chatId = $session['CHAT_ID'];

    $CIMChat = new \CIMChat();
    $history = $CIMChat->GetLastMessageLimit($chatId, $session['START_ID'], $session['END_ID'], true, false);

    if ($history && isset($history['message'])) {
        foreach ($history['message'] as $id => $message) {
            if (isset($message['params']['FILE_ID'])) {
                foreach ($message['params']['FILE_ID'] as $fileId) {
                    $file = \Bitrix\Disk\File::getById($fileId);
                    $fileCreatedTime = $file->getCreateTime();
                    $nowTime = new \Bitrix\Main\Type\DateTime();
                    $dateDiff = $fileCreatedTime->getDiff($nowTime)->days;
                    if ($dateDiff > 182) {
                        $file->delete($fileId);
                    }
                }
            }
        }
    }
}

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');