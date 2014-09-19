<?php

/*
 * Copyright (C) 2013 Vitaliy Pylypiv <vitaliy.pylypiv@gmail.com>
 *
 * This file is part of FusionForge.
 *
 * FusionForge is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published
 * by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * FusionForge is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

$taskboard->header(
	array(
		'title'=>'Taskboard for '.$group->getPublicName().' : Administration : Columns configuration' ,
		'pagename'=>_('Columns configuration'),
		'sectionvals'=>array(group_getname($group_id)),
		'group'=>$group_id
	)
);

if( $taskboard->isError() ) {
	echo '<div id="messages" class="error">'.$taskboard->getErrorMessage().'</div>';
} else {
	echo '<div id="messages" style="display: none;"></div>';
}

$column_title = getStringFromRequest('column_title','');
$title_bg_color = getStringFromRequest('title_bg_color','');
$color_bg_color = getStringFromRequest('column_bg_color','');
$column_max_tasks = getStringFromRequest('column_max_tasks','');


if (getStringFromRequest('post_changes')) {
	$taskboard->addColumn($column_title, $title_bg_color, $color_bg_color, $column_max_tasks);
}

$columns = $taskboard->getColumns();
?>

<?php

        $tablearr = array(_('Order'),_('Title'),_('Max number of tasks'),_('Resolutions'));

        echo $HTML->listTableTop($tablearr, false, 'sortable_table_tracker', 'sortable_table_tracker');
        foreach( $columns as $column ) {
		echo '
                <tr valign="middle">
			<td>'.$column->getOrder().'</td>
			<td>
			<div style="float: left; border: 1px solid grey; height: 30px; width: 20px; background-color: '.$column->getColumnBackgroundColor().'; margin-right: 10px;"><div style="width: 100%; height: 10px; background-color: '.$column->getTitleBackgroundColor().';"></div></div>'.
				util_make_link ('/plugins/taskboard/admin/?group_id='.$group_id.'&amp;action=edit_column&amp;column_id='.$column->getID(),
                        	$column->getTitle() ).'</a></td>
			<td>'.$column->getMaxTasks().'</td>
			<td>'.implode(', ', array_values( $column->getResolutions() )).'</td>
		</tr>
		';
	}
	echo $HTML->listTableBottom();

?>

<form action="/plugins/taskboard/admin/?group_id=<?= $group_id ?>&amp;action=columns" method="post">
<input type="hidden" name="post_changes" value="y">

<h2>Add new column:</h2>
<table>
                        <tr><td><strong><?php echo _('Title') ?></strong>&nbsp;<?php echo utils_requiredField(); ?></td><td><input type="text" name="column_title"></td></tr>
                        <tr><td><strong><?php echo _('Title backgound color') ?></strong></td><td><?= $taskboard->colorBgChooser('title_bg_color') ?></td></tr>
                        <tr><td><strong><?php echo _('Column Background color') ?></strong></td><td><?= $taskboard->colorBgChooser('column_bg_color', 'none') ?></td></tr>
			<tr><td><strong><?php echo _('Maximum tasks number') ?></strong></td><td><input type="text" name="column_max_tasks"></td></tr>
                </table>

<p>
<input type="submit" name="post_changes" value="<?php echo _('Submit') ?>" />
</p>

<?php
        echo utils_requiredField().' '._('Indicates required fields.');
?>
