<tr>
    <td><?= $row->userid; ?></td>
    <td><?= $row->username; ?></td>
    <td><?= empty($group) ? '' : $group[0]['name']; ?></td>
    <td><?= $row->email; ?></td>
    <td align="center">
        <a href="#" class="btn btn-success btn-circle btn-sm btn-change-group" data-id="<?= $row->userid; ?>" title="Ubah Grup">
            <i class="fas fa-tasks"></i>
        </a>
    </td>
</tr>