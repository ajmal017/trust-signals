<tr class="order-%id%">
    <td>%id%</td>
    <td>%date%</td>
    <td><a href="%uri%/users/%email%_page1">%email%</a></td>
    <td class="text-left status-order-%id%">%status%</td>
    <td class="text-left">$%summ%</td>
    <td class="text-center">
        <span data-toggle="modal"  data-target="#send-mess" data-user="%user_id%" class="send-message moderation-link label label-primary"><span class="glyphicon glyphicon-envelope"></span></span>
        %confirm%
        <span data-toggle="tooltip" data-placement="top" title="Удалить" data-id="%id%" class="remove-order moderation-link label label-danger"><span class="glyphicon glyphicon-trash"></span></span>
    </td>
</tr>