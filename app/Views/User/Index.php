<a href="<?=site_url('user/create/')?>">Create random</a>
<hr />
<table style="width:100%;">

    <?php foreach($users as $user): if($user instanceof App\Models\User) ?>

    <tr>
        <td><?=$user->getFirstname()?></td>
        <td><?=$user->getLastname()?></td>
        <td><?=$user->getUsername()?></td>
        <td><?=$user->getRole()?></td>
        <td><?=$user->getCreated()->format('d/m/Y')?></td>
        <td><a href="<?=site_url('user/delete/'.$user->getId())?>">Delete</a></td>
    </tr>

    <?php endforeach; ?>

</table>
