<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
require_once '../init.php';
$db = DB::getInstance();
$response = $html = '';
if (isset($user) && $user->isLoggedIn()) {
    $user_id = $user->data()->id;
    $notifications = new Notification($user_id);
    if ($notifications->getCount() > 0) {
        $html = '<ul>';
        foreach ($notifications->getNotifications() as $notif) {
            $html .= '<li>';
            if ($notif->is_read == 0) $html .= '<span class="badge badge-notif">NEW</span> ';
            $html .= $notif->message;
            $html .='&nbsp;&nbsp;<span class="small">('.time2str($notif->date_created).')</span></li>';
        }
        $html .= '</ul>';
    }
    else {
        $html = '<div class="text-center">You have no notifications at this time.</div>';
    }
    $notifications->setReadAll();
    if ($notifications->getError() != '') $html = $notifications->getError();
}
else return false;
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($html);
    exit;
}
