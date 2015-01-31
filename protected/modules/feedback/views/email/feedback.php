<tr>
	<td style="border-bottom:3px solid #F0474D; font-size:17px;font-weight: bold;" valign="middle" align="left" width="150">
		<strong><a href="http://<?=$_SERVER['SERVER_NAME'];?>" title="<?=Yii::app()->params['siteName'];?>"><?=Yii::app()->params['siteName'];?></a></strong>
	</td>
	<td style="border-bottom:3px solid #F0474D; font-size:17px;" align="center" valign="middle">
		<b><?=$subject;?></b>
	</td>
</tr>
<tr>
	<td style="padding-top:15px; font-size:17px;" colspan="2">
		<table>
			<tr>
				<td>Тема: </td>
				<td><?=$model->theme;?></td>
			</tr>
			<tr>
				<td>Имя: </td>
				<td><?=$model->name;?></td>
			</tr>
			<tr>
				<td>Email: </td>
				<td><?=$model->email;?></td>
			</tr>
			<tr>
				<td>Сообщение: </td>
				<td><?=$model->text;?></td>
			</tr>
		</table>
	</td>
</tr>