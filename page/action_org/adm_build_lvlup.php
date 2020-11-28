<?php

$bank = Bank::account_info($info['main_bank_acc']);

if ($bank['balance'] >= $oplata['build_company_upgrade_cost']) {

    $bc = Bank::transfer($bank['id'], _KIBANK, $oplata['build_company_upgrade_cost'], 'Opłata za rozwój organizacji' . $id);
    if ($bc == 'OK') {
        $newLevel = $info_build['level'] + 1;
        $newTime = $info_build['time_multiplier'] * $oplata['build_company_upgrade_multi'];
        $newCost = $info_build['cost_multiplier'] * $oplata['build_company_upgrade_multi'];
        $newLimit = $info_build['build_limit'] + 5;
        update('up_organizations_building', 'organization_id', $id, 'level', $newLevel);
        update('up_organizations_building', 'organization_id', $id, 'time_multiplier', $newTime);
        update('up_organizations_building', 'organization_id', $id, 'cost_multiplier', $newCost);
        update('up_organizations_building', 'organization_id', $id, 'build_limit', $newLimit);
        header('Location: ' . _URL . '/profil/' . $id . '/LVL_OK');
    }

} else header('Location: ' . _URL . '/profil/' . $id . '/MONEY');
