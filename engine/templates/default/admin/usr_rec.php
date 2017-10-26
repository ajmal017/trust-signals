<tr valign="middle" class="user-admin-box user-num-%user_id%">
    <td>
        <img src="%user_img%" alt="ALT"/> <span class="user-subhead">%name% %type% %activate_user%</span>
    </td>
    <td valign="middle">
        <span class="user-subhead"><span class="glyphicon glyphicon-calendar"></span> %date%</span>
    </td>
    <td class="text-center">
        %status%
    </td>
    <td>
        %email% <span class="banned-%user_id%">%banned%</span>
    </td>
    <td class="text-center">
        <span data-toggle="modal"  data-target="#send-mess-post" data-email="%email%" data-user="%user_id%" class="send-post moderation-link label label-warning user-send-mess-%user_id%"><span class="glyphicon glyphicon-envelope"></span></span>
        <span data-toggle="modal"  data-target="#send-mess" data-user="%user_id%" class="send-message moderation-link label label-primary user-send-mess-%user_id%"><span class="glyphicon glyphicon-envelope"></span></span>
        <span data-toggle="modal"  data-target="#settings" data-from="%from_reg%" data-soc="%address%" data-email="%email%" data-time-vip="%time_vip%" data-timeleft="%timeleft%" data-user="%user_id%" class="edit-user moderation-link label label-warning"><span class="glyphicon glyphicon-pencil"></span></span>
        <span data-toggle="tooltip" data-placement="top" title="Удалить" data-id="%user_id%" class="remove-user moderation-link label label-danger"><span class="glyphicon glyphicon-trash"></span></span>
    </td>
</tr>