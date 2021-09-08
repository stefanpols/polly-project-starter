<a href="<?=site_url('user/create/')?>" class="btn btn-primary">Create random</a>
<hr />

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Users</h5>
    </div>

    <div class="card-body">
        <table  class="table table-striped" style="width:100%;">

            <?php foreach($users as $user): if($user instanceof App\Models\User) ?>

                <tr>
                <td><?=$user->getFirstname()?></td>
                <td><?=$user->getLastname()?></td>
                <td><?=$user->getUsername()?></td>
                <td><?=$user->getRole()?></td>
                <td><?=$user->getCreated()->format('d/m/Y')?></td>
                <td><a href="<?=site_url('user/delete/'.$user->getId())?>"  class="btn btn-danger btn-sm">Delete</a></td>
                </tr>

            <?php endforeach; ?>

        </table>
    </div>

</div>

