<?php
/*
 *  s42transfer, your web file repository
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');
require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');
require (JIRAFEAU_ROOT . 'lib/template/header.php');

$url = $cfg['web_root'] . 'tos.php';
$org = "[THIS WEBSITE]";
$contact = "
By email:
    admin@[THIS WEBSITE]
";

include (JIRAFEAU_ROOT . 'tos_text.php');

//echo '<h2>Terms of Service</h2>';
echo '<div class="terms-containers">';
echo '<h1>Terms of Service</h1>';
echo '<textarea readonly="readonly" rows="210" cols="80">'.$tos.'</textarea>';

echo '</div>';
require (JIRAFEAU_ROOT . 'lib/template/footer.php');
?>
