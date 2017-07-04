<?php
/**
 * /assets/edit/registrar-fee.php
 *
 * This file is part of DomainMOD, an open source domain and internet asset manager.
 * Copyright (c) 2010-2017 Greg Chetcuti <greg@chetcuti.com>
 *
 * Project: http://domainmod.org   Author: http://chetcuti.com
 *
 * DomainMOD is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * DomainMOD is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with DomainMOD. If not, see
 * http://www.gnu.org/licenses/.
 *
 */
?>
<?php
require_once __DIR__ . '/../../_includes/start-session.inc.php';
require_once __DIR__ . '/../../_includes/init.inc.php';

require_once DIR_ROOT . '/vendor/autoload.php';

$system = new DomainMOD\System();
$log = new DomainMOD\Log('/assets/edit/registrar-fee.php');
$layout = new DomainMOD\Layout();
$time = new DomainMOD\Time();
$form = new DomainMOD\Form();
$conversion = new DomainMOD\Conversion();
$assets = new DomainMOD\Assets();

require_once DIR_INC . '/head.inc.php';
require_once DIR_INC . '/config.inc.php';
require_once DIR_INC . '/software.inc.php';
require_once DIR_INC . '/debug.inc.php';
require_once DIR_INC . '/settings/assets-edit-registrar-fee.inc.php';

$timestamp = $time->stamp();
$pdo = $system->db();
$system->authCheck();

$fee_id = $_REQUEST['fee_id'];
$rid = $_REQUEST['rid'];
$new_tld = $_POST['new_tld'];
$new_initial_fee = $_POST['new_initial_fee'];
$new_renewal_fee = $_POST['new_renewal_fee'];
$new_transfer_fee = $_POST['new_transfer_fee'];
$new_privacy_fee = $_POST['new_privacy_fee'];
$new_misc_fee = $_POST['new_misc_fee'];
$new_currency_id = $_POST['new_currency_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $system->readOnlyCheck($_SERVER['HTTP_REFERER']);

    if ($new_initial_fee != '' && $new_renewal_fee != '' && $new_transfer_fee != '') {

        try {

            $pdo->beginTransaction();

            $new_tld = trim($new_tld, ". \t\n\r\0\x0B");

            $stmt = $pdo->prepare("
                UPDATE fees
                SET initial_fee = :new_initial_fee,
                    renewal_fee = :new_renewal_fee,
                    transfer_fee = :new_transfer_fee,
                    privacy_fee =:new_privacy_fee,
                    misc_fee = :new_misc_fee,
                    currency_id = :new_currency_id,
                    update_time = :timestamp
                WHERE registrar_id = :rid
                  AND tld = :new_tld");
            $stmt->bindValue('new_initial_fee', strval($new_initial_fee), PDO::PARAM_STR);
            $stmt->bindValue('new_renewal_fee', strval($new_renewal_fee), PDO::PARAM_STR);
            $stmt->bindValue('new_transfer_fee', strval($new_transfer_fee), PDO::PARAM_STR);
            $stmt->bindValue('new_privacy_fee', strval($new_privacy_fee), PDO::PARAM_STR);
            $stmt->bindValue('new_misc_fee', strval($new_misc_fee), PDO::PARAM_STR);
            $stmt->bindValue('new_currency_id', $new_currency_id, PDO::PARAM_INT);
            $stmt->bindValue('timestamp', $timestamp, PDO::PARAM_STR);
            $stmt->bindValue('rid', $rid, PDO::PARAM_INT);
            $stmt->bindValue('new_tld', $new_tld, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $pdo->prepare("
                UPDATE domains
                SET fee_id = :fee_id,
                    update_time = :timestamp
                WHERE registrar_id = :rid
                  AND tld = :new_tld");
            $stmt->bindValue('fee_id', $fee_id, PDO::PARAM_INT);
            $stmt->bindValue('timestamp', $timestamp, PDO::PARAM_STR);
            $stmt->bindValue('rid', $rid, PDO::PARAM_INT);
            $stmt->bindValue('new_tld', $new_tld, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $pdo->prepare("
                UPDATE domains d
                JOIN fees f ON d.fee_id = f.id
                SET d.total_cost = f.renewal_fee + f.privacy_fee + f.misc_fee
                WHERE d.privacy = '1'
                  AND d.fee_id = :fee_id");
            $stmt->bindValue('fee_id', $fee_id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $pdo->prepare("
                UPDATE domains d
                JOIN fees f ON d.fee_id = f.id
                SET d.total_cost = f.renewal_fee + f.misc_fee
                WHERE d.privacy = '0'
                  AND d.fee_id = :fee_id");
            $stmt->bindValue('fee_id', $fee_id, PDO::PARAM_INT);
            $stmt->execute();

            $conversion->updateRates($_SESSION['s_default_currency'], $_SESSION['s_user_id']);

            $pdo->commit();

            $_SESSION['s_message_success'] .= "The fee for ." . $new_tld . " has been updated<BR>";

            header("Location: ../registrar-fees.php?rid=" . urlencode($rid));
            exit;

        } catch (Exception $e) {

            $pdo->rollback();

            $log_message = 'Unable to update registrar fee';
            $log_extra = array('Error' => $e);
            $log->error($log_message, $log_extra);

            $_SESSION['s_message_danger'] .= $log_message . '<BR>';

            throw $e;

        }

    } else {

        if ($new_initial_fee == '') $_SESSION['s_message_danger'] .= "Enter the initial fee<BR>";
        if ($new_renewal_fee == '') $_SESSION['s_message_danger'] .= "Enter the renewal fee<BR>";
        if ($new_transfer_fee == '') $_SESSION['s_message_danger'] .= "Enter the transfer fee<BR>";

    }

} else {

    $stmt = $pdo->prepare("
        SELECT registrar_id, tld, initial_fee, renewal_fee, transfer_fee, privacy_fee, misc_fee, currency_id
        FROM fees
        WHERE id = :fee_id");
    $stmt->bindValue('fee_id', $fee_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {

        $rid = $result->registrar_id;
        $new_tld = $result->tld;
        $new_initial_fee = $result->initial_fee;
        $new_renewal_fee = $result->renewal_fee;
        $new_transfer_fee = $result->transfer_fee;
        $new_privacy_fee = $result->privacy_fee;
        $new_misc_fee = $result->misc_fee;
        $new_currency_id = $result->currency_id;

    }

}
?>
<?php require_once DIR_INC . '/doctype.inc.php'; ?>
<html>
<head>
    <title><?php echo $system->pageTitle($page_title); ?></title>
    <?php require_once DIR_INC . '/layout/head-tags.inc.php'; ?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<?php require_once DIR_INC . '/layout/header.inc.php'; ?>
<a href="../registrar-fees.php?rid=<?php echo urlencode($rid); ?>"><?php echo $layout->showButton('button', 'Back to Registrar Fees'); ?></a><BR><BR>
<?php
echo $form->showFormTop('');
$temp_registrar = $assets->getRegistrar($rid);
?>
<strong>Domain Registrar</strong><BR>
<?php echo $temp_registrar; ?><BR><BR>
<strong>TLD</strong><BR>
<?php echo '.' . htmlentities($new_tld, ENT_QUOTES, 'UTF-8'); ?><BR><BR>
<?php
echo $form->showInputText('new_initial_fee', 'Initial Fee', '', $new_initial_fee, '10', '', '1', '', '');
echo $form->showInputText('new_renewal_fee', 'Renewal Fee', '', $new_renewal_fee, '10', '', '1', '', '');
echo $form->showInputText('new_transfer_fee', 'Transfer Fee', '', $new_transfer_fee, '10', '', '1', '', '');
echo $form->showInputText('new_privacy_fee', 'Privacy Fee', '', $new_privacy_fee, '10', '', '', '', '');
echo $form->showInputText('new_misc_fee', 'Misc Fee', '', $new_misc_fee, '10', '', '', '', '');

$result = $pdo->query("
    SELECT id, currency, `name`, symbol
    FROM currencies
    ORDER BY `name`")->fetchAll();

if ($result) {

    echo $form->showDropdownTop('new_currency_id', 'Currency', '', '', '');

    foreach ($result as $row) {

        echo $form->showDropdownOption($row->id, $row->name . ' (' . $row->currency . ')', $new_currency_id);

    }

    echo $form->showDropdownBottom('');

}

echo $form->showInputHidden('fee_id', $fee_id);
echo $form->showInputHidden('rid', $rid);
echo $form->showInputHidden('new_tld', $new_tld);
echo $form->showSubmitButton('Save', '', '');
echo $form->showFormBottom('');
?>
<?php require_once DIR_INC . '/layout/footer.inc.php'; ?>
</body>
</html>
